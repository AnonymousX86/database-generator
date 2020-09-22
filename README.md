# Database generator

###### (alpha version)

## Purpose

Web application should generate `.sql` files with database creation script or work on existing MySQL/MariaDB 
(for example XAMPP MariaDB server) database server.

See simple docs below.

## JS to PHP communication

These are variables accessible via `$_POST[]` array.

| Variable name   | Description                           | About value(s)             |
| :-------------- | :------------------------------------ | :------------------------- |
| predefined      | One from predefined database schemes. |`none` means custom scheme. |
| db_rows         | Rows to generate per table.           | 100 - 10 000.              |
| db_name         | Database name.                        | 3 - 40 characters.         |
| db_tables_count | Number of tables to generate.         | 1 - 3.                     |

Form uses client-side validation. So server-side validation is optional.

### Predefined databases

| predefined      | students-marks  |
| :-------------- | :-------------- |
| db_name         | uczniowie_oceny |
| db_tables_count | 3               |

`db_rows` is never predefined.

## How to use

**Important!** Project uses JS and PHP, so to use this generator you have to use PHP interpreter.

Please follow these steps:

1. Install `node.js` from <https://nodejs.org/en/>.
2. Download code.
3. Run `npm run build` in project root directory.
4. Copy `dist` folder to the web server.
5. Open any web browser and access `dist` folder.

