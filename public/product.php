<?php

require_once __DIR__ . '/../lib/functions.php';
require_once __DIR__ . '/../lib/dbconn.php';

$errormsg = null;
$successmsg = null;

if (isset($_POST['submit']) && isValidProduct($_POST['product'])) {
    $product = getProduct($_POST['product']);
    $db->beginTransaction();
    try {
        $stm = $db->prepare('INSERT INTO products (name, unit_price, stock) VALUES (?, ?, ?)');
        $stm->execute([$product['name'], $product['unit_price'], $product['stock']]);
        $db->commit();
        $successmsg = 'Product was saved successfully!';
    } catch (Exception $e) {
        $db->rollBack();
        $errormsg = 'Product could not be added! :(';
    }
}
$stm = $db->prepare('SELECT * FROM products');
$stm->execute();
$products = $stm->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
<head></head>
<body>
<?php if (null !== $errormsg): ?>
    <div class="alert error"><?php echo $errormsg; ?> </div>
<?php elseif (isset($product)): ?>
    <div class="alert success"><?php echo $successmsg; ?></div>
<?php endif; ?>
<h3>Products</h3>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>PRODUCT</th>
        <th>UNIT PRICE</th>
        <th>STOCK</th>
        <th>ACTIONS</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo $product['id']; ?> </td>
            <td><?php echo $product['name']; ?> </td>
            <td><?php echo $product['unit_price']; ?> </td>
            <td><?php echo $product['stock']; ?> </td>
            <td><?php echo removeUrl('product.php', $product['id']); ?> </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>