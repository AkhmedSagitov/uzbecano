# Mailcatcher

We use the [XIMA Mail Catcher](https://extensions.typo3.org/extension/xima_typo3_mailcatcher) for our testing and staging environments to fetch mails and display them in a backend module.

## Configuration

Add the following lines to the config/system/environments/testing.php|staging.php files to enable the mail catcher for these environments:

```php
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'mbox';
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_mbox_file'] = \TYPO3\CMS\Core\Core\Environment::getVarPath() . '/log/mail.log';
```
