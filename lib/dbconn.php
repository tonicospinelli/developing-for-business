<?php

require_once __DIR__ . '/../config/app.php';

/**
 * @return PDO
 */
function dbConnect()
{
    return new PDO(DATABASE_DSN, DATABASE_USERNAME, DATABASE_PASSWORD);
}
