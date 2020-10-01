# Database generator

###### (in-dev version)

## Purpose

Web application should generate `.sql` files with database creation script.

See simple docs below.

## JS to PHP communication

These are variables accessible via `$_POST` array.

Form uses client-side validation. So server-side validation is optional.

### Table

| Variable name           | Description                           | About value(s)              |
| :---------------------- | :------------------------------------ | :-------------------------- |
| `predefined`            | One from predefined database schemes. |`none` means custom scheme.  |
| `db_rows`               | Rows to generate per table.           | 100 - 10 000.               |
| `db_name`               | Database name.                        | 3 - 40 characters.          |
| `db_tables_count`       | Number of tables to generate.         | 1 - 3.                      |
| `tables[x][title]`      | X table's title.                      | 3 - 40 characters.          |
| `tables[x][cols_count]` | X table's columns count.              | 2 - 4.                      |
| `tables[x][y][scheme]`  | X table's Y column's scheme.          | See columns' schemes below. |
| `tables[x][y][title]`   | X table's Y column's title.           | As above.                   |

### JSON representation
```json
{
  "predefined": "predefined scheme name",
  "db_rows": 5000,
  "db_name": "database name",
  "db_tables_count": 3,
  "tables": {
    "0": {
      "title": "1st table title",
      "cols_count": 2,
      "0": {
        "scheme": "id",
        "title": "some id"
      },
      "1": {
        "scheme": "name",
        "tile": "just a name"
      },
    },
    "1": {
      "title": "2nd table title",
      "cols_count": 2,
      "0": {
       "scheme": "surname",
       "tile": "last name i think"
     },
      "1": {
        "scheme": "pesel",
        "tile": "unique number"
      },
    }
  }
}
```

### Predefined databases

| `predefined`      | `students-marks`  |
| :---------------- | :---------------- |
| `db_name`         | `uczniowie_oceny` |
| `db_tables_count` | `3`               |

`db_rows` is never predefined.


### Columns' schemes

| `tables[x][y][scheme]` | Field type    | Additional info              |
| :--------------------- | :------------ | :--------------------------- |
| `id`                   | `INT`         | `PRIMARY KEY AUTO INCREMENT` |
| `name`                 | `VARCHAR(40)` | `NOT NULL`                   |
| `surname`              | `VARCHAR(40)` | `NOT NULL`                   |
| `gender`               | `VARCHAR(1)`  | `NOT NULL`                   |
| `pesel`                | `VARCHAR(11)` | `NOT NULL`                   |
| `class`                | `VARCHAR(4)`  | `NOT NULL`                   |
| `birthday`             | `DATE`        | `NOT NULL`                   |

This data is not included in `POST`.

## How to use

**Important!** Project uses JS and PHP, so to use this generator you have to use PHP interpreter.

Please follow these steps:

1. Install `node.js` from <https://nodejs.org/en/>.
1. Download code.
1. Run `npm install` in project root directory to install node dependencies.
1. Run `npm run build` in project root directory to build app.
1. Copy `dist` folder to the web server.
1. Open any web browser and access `dist` folder.

