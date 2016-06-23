<?php

use Develop\Business\Product\Exceptions\ProductNotFoundException;
use Develop\Business\Product\Factory as ProductFactory;
use Develop\Business\Product\Intentions\AddProduct as AddProductIntention;
use Develop\Business\Application\Product\Repositories\Product as ProductRepository;
use Develop\Business\Product\UseCases\AddProduct as AddProductUseCase;

function productListAction()
{
    $db = dbConnect();
    $repository = new ProductRepository($db);
    $products = $repository->findAll();
    include TEMPLATE_DIR . '/products/list.php';
}

/**
 * @param $post
 */
function productAddAction($post)
{
    $product = $post['product'];

    $db = dbConnect();

    $intention = new AddProductIntention($product['name'], $product['unit_price'], $product['stock']);
    $repository = new ProductRepository($db);
    try {
        $useCase = new AddProductUseCase($repository, new ProductFactory());
        $product = $useCase->execute($intention);
        $successmsg = "Product {$product->getName()} added successful";
    } catch (\Develop\Business\Product\Exceptions\ProductExistsException $e) {
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
        $repository->delete($product);
        header('Location: /index.php/products');
    } catch (ProductNotFoundException $e) {
        $errormsg = $e->getMessage();
    }
    productListAction();
}
