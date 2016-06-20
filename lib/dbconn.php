<?php

/**
 * @return PDO
 */
function dbConnect()
{
    return new PDO(DATABASE_DSN, DATABASE_USERNAME, DATABASE_PASSWORD);
}
