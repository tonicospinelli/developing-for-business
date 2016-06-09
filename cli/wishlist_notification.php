<?php

require_once __DIR__ . '/../lib/functions.php';
require_once __DIR__ . '/../lib/dbconn.php';

$query = <<<SQL
SELECT
  wishlists.id, wishlists.email, products.name as product_name
FROM
  wishlists
INNER JOIN
  products ON products.id = product_id
WHERE
  products.stock > 0
  AND wishlists.status = 'P'
SQL;
$stm = $db->prepare($query);
$stm->execute();
$wishlists = $stm->fetchAll(PDO::FETCH_ASSOC);

foreach ($wishlists as $wishlist) {
    echo sprintf(
            'sending email for: %s with "%s".',
            $wishlist['email'],
            $wishlist['product_name']
        ) . PHP_EOL;
    $stm = $db->prepare("UPDATE wishlists SET status = 'S' WHERE id = ?");
    $stm->execute([$wishlist['id']]);
}