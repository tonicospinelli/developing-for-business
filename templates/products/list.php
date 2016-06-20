<?php $title = 'List of Producst' ?>

<?php ob_start() ?>
    <h3>Products</h3>
    <?php if (isset($errormsg)): ?>
        <div class="alert error"><?php echo $errormsg; ?> </div>
    <?php elseif (isset($product)): ?>
        <div class="alert success"><?php echo $successmsg; ?></div>
    <?php endif; ?>
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
                <td><?php echo removeUrl('products', $product['id']); ?> </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php $content = ob_get_clean() ?>

<?php include __DIR__.'/../layout.php' ?>