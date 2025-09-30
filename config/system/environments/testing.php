<?php

$GLOBALS['TYPO3_CONF_VARS']['BE']['debug'] = true;
$GLOBALS['TYPO3_CONF_VARS']['FE']['debug'] = true;
$GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask'] = '*';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors'] = 1;
$GLOBALS['TYPO3_CONF_VARS']['SYS']['exceptionalErrors'] = 12290;
$GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] .= ' | Testing';

$GLOBALS['TYPO3_CONF_VARS']['MAIL'] = [
    'transport' => 'sendmail',
    'transport_sendmail_command' => '/usr/sbin/sendmail -t -i -f hostmaster@Leuchtfeuer.com',
    'transport_smtp_encrypt' => '',
    'transport_smtp_password' => '',
    'transport_smtp_server' => '',
    'transport_smtp_username' => '',
];
