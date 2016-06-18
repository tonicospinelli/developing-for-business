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
            <?php if ($wish['status'] == 'P' && $wish['product_stock'] == 0): ?>
                <td>Not Available</td>
            <?php else: ?>
                <td>Available</td>
            <?php endif; ?>
            <td><?php echo removeUrl('wishlist.php', $wish['id'], ['email' => $_GET['email']]); ?> </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>