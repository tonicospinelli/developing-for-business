<?php

use Develop\Business\Product\Exceptions\ProductException;
use Develop\Business\Product\Product;
use Develop\Business\Product\Repositories\Product as ProductRepository;

function productListAction()
{
    $db = dbConnect();
    $repository = new ProductRepository($db);
    $products = $repository->findAll();
    include TEMPLATE_DIR . '/products/list.php';
}

function productAddAction($post)
{
    $product = getProductFromPost($post['product']);

    $db = dbConnect();
    $repository = new ProductRepository($db);

    try {
        if ($repository->findByName($product->getName())) {
            throw ProductException::exists($product->getName());
        }
        $product = $repository->add($product);
        $successmsg = 'Product was saved successfully!';
    } catch (ProductException $e) {
        $errormsg = $e->getMessage();
    }
    productListAction();
}

function productRemoveAction($id)
{
    $db = dbConnect();
    $repository = new ProductRepository($db);

    try {
        $product = $repository->find($id);
        if (!$product instanceof Product) {
            throw ProductException::notFound($id);
        }
        $repository->delete($product);
        header('Location: /index.php/products');
    } catch (ProductException $e) {
        $errormsg = $e->getMessage();
    }
    productListAction();
}
