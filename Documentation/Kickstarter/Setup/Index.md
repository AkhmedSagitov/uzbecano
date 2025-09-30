# Setup

1. Check if [DDEV](https://ddev.com/get-started/) is set up and running.
2. Checkout this repo on your local machine.
3. Run the following command in the document root of the kickstarter project to start DDEV and install TYPO3:

```bash
ddev start && ddev composer i
```

3. (optional) Import the database provided by this repository for a basic setup:

```bash
ddev import-db --file=setup-db.sql.gz
```

4. Check if https://kickstarter.ddev.site/ is up and running.
