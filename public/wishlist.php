<?php

require_once __DIR__ . '/../lib/functions.php';
require_once __DIR__ . '/../lib/dbconn.php';

$errormsg = null;
$successmsg = null;

if (isset($_POST['submit']) && isValidWishList($_POST['wish_item'])) {
    $wishItem = getWishList($_POST['wish_item']);
    $db->beginTransaction();
    try {
        $stm = $db->prepare('INSERT INTO wishlists (email, product_id) VALUES (?, ?)');
        $stm->execute([$wishItem['email'], $wishItem['product_id']]);
        $db->commit();
        $successmsg = 'Product was added at wish list successfully!';
    } catch (Exception $e) {
        $db->rollBack();
        $errormsg = 'Product could not be added at wishlist! :(';
    }
}

if (isset($_GET['remove'])) {
    $db->beginTransaction();
    try {
        $stm = $db->prepare('DELETE FROM wishlists WHERE id = ?');
        $stm->execute([$_GET['remove']]);
        $db->commit();
        $successmsg = 'Product was removed from wish list successfully!';
    } catch (Exception $e) {
        $db->rollBack();
        $errormsg = 'Product could not be removed at wishlist! :(';
    }
    header('Location: /wishlist.php?' . http_build_query(['email' => $_GET['email']]));
}

$query = <<<SQL
SELECT
  wishlists.id, products.name as product_name,  products.stock as product_stock, wishlists.status
FROM
  wishlists
INNER JOIN 
  products ON products.id = product_id 
WHERE email = ?
SQL;

$stm = $db->prepare($query);
$stm->execute([$_GET['email']]);
$wishlist = $stm->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/../templates/wishlists/list.php';