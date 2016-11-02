<?php

$config = array(
    'db.options' => array(
        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'	=> 'mayookha',
        'user'		=> 'mayookha',
        'password'	=> 'password'
    ),
    'db.dbal.class_path'    => __DIR__.'/../vendor/doctrine/dbal/lib',
    'db.common.class_path'  => __DIR__.'/../vendor/doctrine/common/lib',
);

return $config;

