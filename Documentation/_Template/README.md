# Kickstarter

## Prerequisites

* Check if [DDEV](https://ddev.com/get-started/) is set up and running.

## Setup

1. Checkout this repo on your local machine.
2. Run the following command in the document root of the project to start DDEV and install TYPO3:

```bash
ddev start && ddev composer i
```

3. Import the database via reverse deployment:

```bash
ddev reverse
```

4. Check if https://kickstarter.ddev.site/ is up and running.

## Asset generation
Assets are generated with the node script `Build/scripts/build-assets.ts` which utilizes **vite** under the hood. To generate the project's assets simply run `ddev assets` For help and more information about this command run `ddev assets --help`
Entry files with their output points as well as folders for SVG sprite generation are defined in `Build/assets.config.json`

## Run Checker/Fixer ##

* Test Code Style: `ddev composer check:cs`
* Fix Code Style: `ddev composer fix:cs`
* Testing with PHP Stan: `ddev composer check:phpstan`
* Run TypoScript Linter: `ddev composer check:typoscript`
* Run XLIFF Linter: `ddev composer check:xliff`
* Run all configured tests: `ddev composer check`
* Run PHP unit tests: `ddev composer test:phpunit`
* Run TYPO3 functional tests: `ddev composer test:functional`
* Run all tests: `ddev composer tests`

## Using b13/make

* Create a TYPO3 extension: `ddev typo3 make:extension`
* Create a backend controller: `ddev typo3 make:backendcontroller`
* Create a console command: `ddev typo3 make:command`
* Create a PSR-14 event listener: `ddev typo3 make:eventlistener`
* Create a PSR-15 middleware: `ddev typo3 make:middleware`

## DDEV Helper
* `ddev sequelace`
    * start Sequel Ace
* `ddev status`
    * check status, get a list of URLs to use
* `ddev htaccess`
    * Add .htaccess file to `public/`
* `ddev typo3-scheduler start|stop|status`
    * Manage TYPO3 scheduler
