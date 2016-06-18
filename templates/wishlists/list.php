<?php $title = 'My Wish List' ?>

<?php ob_start() ?>
    <h3><?php echo $title;?></h3>
    <?php if (isset($errormsg)): ?>
        <div class="alert error"><?php echo $errormsg; ?> </div>
    <?php elseif (isset($wishItem)): ?>
        <div class="alert success"><?php echo $successmsg; ?></div>
    <?php endif; ?>
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
                <?php if ($wish['product_stock'] == 0): ?>
                    <td>Not Available</td>
                <?php else: ?>
                    <td>Available</td>
                <?php endif; ?>
                <td><?php echo removeUrl('wishlist', $wish['id'], ['email' => $_GET['email']]); ?> </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php $content = ob_get_clean() ?>

<?php include __DIR__.'/../layout.php' ?>