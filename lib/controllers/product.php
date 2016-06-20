<?php

function productListAction()
{
    $products = findAllProducts();
    include TEMPLATE_DIR . '/products/list.php';
}

function productAddAction($post)
{
    $product = getProductFromPost($post['product']);

    if (addProduct($product)) {
        $successmsg = 'Product was saved successfully!';
    } else {
        $errormsg = 'Product could not be added! :(';
    }
    productListAction();
}

function productRemoveAction($id)
{
    if (!removeProduct($id)) {
        $errormsg = 'Product could not be removed! :(';
    }

    header('Location: /index.php/products');
}
