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
    header('Location: /wishlist.php?'.http_build_query(['email' => $_GET['email']]));
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
?>
<html>
<head></head>
<body>
<?php if (null !== $errormsg): ?>
    <div class="alert error"><?php echo $errormsg; ?> </div>
<?php elseif (isset($wishItem)): ?>
    <div class="alert success"><?php echo $successmsg; ?></div>
<?php endif; ?>
<h3>My Wish List</h3>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>PRODUCT</th>
        <th>STATUS</th>
        <th>ACTIONS</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($wishlist as $wish): ?>
        <tr>
            <td><?php echo $wish['id']; ?> </td>
            <td><?php echo $wish['product_name']; ?> </td>
            <td><?php echo ($wish['status'] == 'P' && $wish['product_stock'] == 0 ? 'Not Available' : 'Available'); ?> </td>
            <td><?php echo removeUrl('wishlist.php', $wish['id'], ['email' => $_GET['email']]); ?> </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>