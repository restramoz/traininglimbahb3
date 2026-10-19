import sqlite3
from pathlib import Path

db_path = Path("database/traininglimbahb3.sqlite")
if not db_path.exists():
    raise SystemExit("ERROR: database/traininglimbahb3.sqlite tidak ditemukan")

conn = sqlite3.connect(db_path)
conn.row_factory = sqlite3.Row

def q(name):
    return "`" + name.replace("`", "``") + "`"

def mysql_type(col_type, is_primary=False):
    t = (col_type or "").upper()

    if is_primary and t == "INTEGER":
        return "BIGINT UNSIGNED NOT NULL AUTO_INCREMENT"
    if "JSON" in t:
        return "JSON"
    if "BOOL" in t:
        return "TINYINT(1)"
    if "INT" in t:
        return "BIGINT UNSIGNED" if t == "INTEGER" else "BIGINT"
    if "REAL" in t or "FLOA" in t or "DOUB" in t:
        return "DOUBLE"
    if "BLOB" in t:
        return "LONGBLOB"
    if "DATE" in t or "TIME" in t:
        return "DATETIME"
    if "DECIMAL" in t or "NUMERIC" in t:
        return "DECIMAL(20,6)"
    if "TEXT" in t or "CLOB" in t:
        return "LONGTEXT"
    if "CHAR" in t:
        return "VARCHAR(255)"
    return "VARCHAR(255)"

def sql_value(value):
    if value is None:
        return "NULL"
    if isinstance(value, (int, float)):
        return str(value)
    if isinstance(value, bytes):
        return "0x" + value.hex()
    value = str(value).replace("\\", "\\\\").replace("'", "''")
    return "'" + value + "'"

tables = [
    r["name"] for r in conn.execute("""
        SELECT name FROM sqlite_master
        WHERE type='table' AND name NOT LIKE 'sqlite_%'
        ORDER BY name
    """)
]

# ---------- db.sql: schema ----------
schema = [
    "-- Schema MySQL/MariaDB hasil ekspor SQLite.",
    "-- Import ke database kosong terlebih dahulu.",
    "SET FOREIGN_KEY_CHECKS=0;",
]

for table in tables:
    columns = conn.execute(
        f"PRAGMA table_info({q(table)})"
    ).fetchall()

    definitions = []
    primary_keys = [c["name"] for c in columns if c["pk"]]

    for c in columns:
        is_pk = bool(c["pk"]) and len(primary_keys) == 1
        typ = mysql_type(c["type"], is_pk)
        line = f"  {q(c['name'])} {typ}"

        if not is_pk and c["notnull"]:
            line += " NOT NULL"

        default = c["dflt_value"]
        if not is_pk and default is not None:
            d = str(default)
            if d.upper() in ("CURRENT_TIMESTAMP", "CURRENT_TIMESTAMP()"):
                line += " DEFAULT CURRENT_TIMESTAMP"
            elif d in ("0", "1"):
                line += f" DEFAULT {d}"
            elif d.startswith("'") and d.endswith("'"):
                line += f" DEFAULT {d}"
        elif not is_pk and not c["notnull"]:
            line += " DEFAULT NULL"

        definitions.append(line)

    if primary_keys:
        definitions.append(
            "  PRIMARY KEY (" +
            ", ".join(q(c) for c in primary_keys) + ")"
        )

    # Selaraskan tipe tertentu dengan migrasi Laravel asli.
    overrides = {
        "articles": {
            "excerpt": "TEXT",
            "image_brief": "JSON",
            "meta_description": "TEXT",
            "faqs": "JSON",
            "status": "VARCHAR(20)",
        },
        "cities": {
            "is_hub": "TINYINT(1)",
        },
    }

    for i, c in enumerate(columns):
        override = overrides.get(table, {}).get(c["name"])
        if override:
            for j, definition in enumerate(definitions):
                if definition.lstrip().startswith(q(c["name"]) + " "):
                    suffix = ""
                    if c["notnull"]:
                        suffix += " NOT NULL"
                    elif c["dflt_value"] is None:
                        suffix += " DEFAULT NULL"

                    default = c["dflt_value"]
                    if default is not None:
                        d = str(default)
                        if d.upper() in ("CURRENT_TIMESTAMP", "CURRENT_TIMESTAMP()"):
                            suffix += " DEFAULT CURRENT_TIMESTAMP"
                        elif d in ("0", "1"):
                            suffix += f" DEFAULT {d}"
                        elif d.startswith("'") and d.endswith("'"):
                            suffix += f" DEFAULT {d}"

                    definitions[j] = f"  {q(c['name'])} {override}{suffix}"
                    break

    # Ambil foreign key yang didefinisikan pada SQLite.
    for fk in conn.execute(f"PRAGMA foreign_key_list({q(table)})"):
        definitions.append(
            f"  FOREIGN KEY ({q(fk['from'])}) "
            f"REFERENCES {q(fk['table'])} ({q(fk['to'])}) "
            f"ON DELETE {fk['on_delete']}"
        )

    schema.append(
        f"\nCREATE TABLE {q(table)} (\n" +
        ",\n".join(definitions) +
        "\n) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 "
        "COLLATE=utf8mb4_unicode_ci;\n"
    )

    for idx in conn.execute(f"PRAGMA index_list({q(table)})"):
        idx_cols = [
            r["name"] for r in conn.execute(
                f"PRAGMA index_info({q(idx['name'])})"
            ) if r["name"]
        ]
        if not idx_cols or idx["origin"] == "pk":
            continue

        unique = bool(idx["unique"])
        prefix = "UNIQUE " if unique else ""
        idx_name = ("uq_" if unique else "idx_") + table + "_" + "_".join(idx_cols)

        schema.append(
            f"CREATE {prefix}INDEX {q(idx_name)} "
            f"ON {q(table)} (" +
            ", ".join(q(c) for c in idx_cols) + ");\n"
        )

schema.append("\nSET FOREIGN_KEY_CHECKS=1;\n")
Path("db.sql").write_text("\n".join(schema), encoding="utf-8")

# ---------- db-data.sql: data ----------
# Jangan ekspor sesi, cache, atau antrean kerja sementara.
skip_data = {
    "sessions", "cache", "cache_locks",
    "jobs", "job_batches", "failed_jobs"
}

preferred = [
    "migrations", "users", "password_reset_tokens",
    "articles", "cities", "kecamatans"
]
data_tables = [t for t in preferred if t in tables and t not in skip_data]
data_tables += [
    t for t in tables if t not in data_tables and t not in skip_data
]

data = [
    "-- Data hasil ekspor SQLite.",
    "-- Berisi data pengguna dan artikel; jaga kerahasiaannya.",
    "SET FOREIGN_KEY_CHECKS=0;",
]

for table in data_tables:
    rows = conn.execute(f"SELECT * FROM {q(table)}").fetchall()
    if not rows:
        continue

    cols = list(rows[0].keys())
    data.append(f"\n-- {table}: {len(rows)} baris")

    for row in rows:
        values = ", ".join(sql_value(row[c]) for c in cols)
        data.append(
            f"INSERT INTO {q(table)} (" +
            ", ".join(q(c) for c in cols) +
            f") VALUES ({values});"
        )

data.append("\nSET FOREIGN_KEY_CHECKS=1;\n")
Path("db-data.sql").write_text("\n".join(data), encoding="utf-8")

print("File berhasil dibuat:")
for filename in ("db.sql", "db-data.sql"):
    p = Path(filename)
    print(f"  {filename}: {p.stat().st_size:,} bytes")

print("\nJumlah data yang diekspor:")
for table in data_tables:
    count = conn.execute(f"SELECT COUNT(*) FROM {q(table)}").fetchone()[0]
    print(f"  {table}: {count} baris")

conn.close()
