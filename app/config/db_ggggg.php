<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=gamecard',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'tablePrefix' => '',
    'enableSchemaCache' => true,
	
	'schemaCacheDuration'=>3600,
    'enableQueryCache'=>true,
    'queryCacheDuration'=>3600,
];
