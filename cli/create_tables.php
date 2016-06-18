<?php

require_once __DIR__ . '/../lib/dbconn.php';

$db->query("CREATE TABLE IF NOT EXISTS wishlists (id INTEGER PRIMARY KEY AUTOINCREMENT, email varchar(255), product_id int, status VARCHAR(1) DEFAULT 'P');");
$db->query('CREATE TABLE IF NOT EXISTS products (id INTEGER PRIMARY KEY AUTOINCREMENT, name varchar(255), unit_price DECIMAL(10,2), stock int);');
$stm = $db->query("INSERT INTO products VALUES (null, 'T-Shirt', 59.9, 10);");
$stm = $db->query("INSERT INTO products VALUES (null, 'Shorts', 69.9, 10);");
$stm = $db->query("INSERT INTO products VALUES (null, 'Pant', 69.9, 0);");