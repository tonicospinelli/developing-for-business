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
        <?php /** @var \Develop\Business\Wishlist\Wishlist $wishedItem */?>
        <?php foreach ($wishlist as $wishedItem): ?>
            <tr>
                <td><?php echo $wishedItem->getId(); ?> </td>
                <td><?php echo $wishedItem->getItemName(); ?> </td>
                <?php if ($wishedItem->isAvailable()): ?>
                    <td>Available</td>
                <?php else: ?>
                    <td>Not Available</td>
                <?php endif; ?>
                <td><?php echo removeUrl('wishlist', $wishedItem->getId(), ['email' => $_GET['email']]); ?> </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php $content = ob_get_clean() ?>

<?php include __DIR__.'/../layout.php' ?>