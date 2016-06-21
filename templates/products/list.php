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
        <?php /** @var \Develop\Business\Product\Product $product */?>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo $product->getId(); ?> </td>
                <td><?php echo $product->getName(); ?> </td>
                <td><?php echo $product->getUnitPrice(); ?> </td>
                <td><?php echo $product->getStock(); ?> </td>
                <td><?php echo removeUrl('products', $product->getId()); ?> </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php $content = ob_get_clean() ?>

<?php include __DIR__.'/../layout.php' ?>