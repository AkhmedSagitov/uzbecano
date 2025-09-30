# Setup Database

This repository provides a basic setup database to quickly start a TYPO3 project with our standards. The latest dump of
the database is stored in the file `setup-db.sql.gz` in the document root. How to import the database is described above in
the "Setup" section.

## Database content

* Admin User (described above)
* Root-Page with a simple content element
* ... (TBD)

## How to update the basic database setup?

Run the following command to update the file `setup-db.sql.gz` in the document root:

```bash
ddev create-setup-db-file
```

After the database was successfully exported, you have to commit and push your changes to the repository.

ATTENTION: The current file will be overwritten, so keep in mind you do not delete or modify unwanted records.
