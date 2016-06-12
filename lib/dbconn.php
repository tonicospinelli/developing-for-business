<?php

$database = __DIR__ . '/../data/business.db';
$dsn = 'sqlite:' . $database;
$db = new PDO($dsn);

