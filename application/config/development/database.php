<?php

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = trim(`boot2docker ip`);
$db['default']['username'] = 'user';
$db['default']['password'] = 'password';
$db['default']['database'] = 'db';
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;
