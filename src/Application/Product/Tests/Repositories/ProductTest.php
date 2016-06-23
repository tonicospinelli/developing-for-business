<?php

namespace Develop\Business\Application\Product\Tests\Repositories;

use Develop\Business\Product\Exceptions\ProductException;
use Develop\Business\Product\Exceptions\ProductNotFoundException;
use Develop\Business\Product\Product;
use Develop\Business\Application\Product\Repositories\Product as ProductRepository;
use Develop\Business\Application\Product\Tests\Repositories\Stubs\PDOSpy;
use Prophecy\Argument;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testFindAllProducts()
    {
        $pdoSpy = new PDOSpy();

        $repository = new ProductRepository($pdoSpy);

        $products = $repository->findAll();

        $this->assertCount(1, $products);
        $this->assertInstanceOf(Product::class, reset($products));
    }

    public function testFindProductByName()
    {
        $pdoSpy = new PDOSpy();

        $repository = new ProductRepository($pdoSpy);

        $product = $repository->findByName('Shoes');

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Shoes', $product->getName());
    }

    public function testFindProductById()
    {
        $pdoSpy = new PDOSpy();

        $repository = new ProductRepository($pdoSpy);

        $product = $repository->find(1);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals(1, $product->getId());
    }

    public function testNotFindProductById()
    {
        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage('The product(100) was not found.');
        $pdoSpy = new PDOSpy();

        $repository = new ProductRepository($pdoSpy);

        $product = $repository->find(100);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals(1, $product->getId());
    }

    public function testNotFindProductByName()
    {
        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage('The product(Hat) was not found.');

        $pdoSpy = new PDOSpy();

        $repository = new ProductRepository($pdoSpy);

        $repository->findByName('Hat');

    }

    public function testAddNewProductSuccessful()
    {
        $pdoSpy = new PDOSpy();

        $product = new Product('Hat', 19.9, 10);

        $repository = new ProductRepository($pdoSpy);

        $productAdded = $repository->add($product);

        $this->assertTrue($pdoSpy->beginTransactionCalled);
        $this->assertTrue($pdoSpy->commitCalled);

        $this->assertInstanceOf(Product::class, $productAdded);
        $this->assertEquals('Hat', $productAdded->getName());
        $this->assertEquals(2, $productAdded->getId());
    }

    public function testAddNewProductFailed()
    {
        $this->expectException(ProductException::class);
        $this->expectExceptionMessage('The product(T-Shirt) was not added');

        $product = new Product('T-Shirt', 99.9, 10, 1);

        $pdoSpy = new PDOSpy();
        $pdoSpy->failureOnWrite = true;

        $repository = new ProductRepository($pdoSpy);

        $repository->add($product);
    }

    public function testDeleteProductSuccessful()
    {
        $product = new Product('Shoes', 69.9, 0, 1);

        $pdoSpy = new PDOSpy();

        $repository = new ProductRepository($pdoSpy);

        $result = $repository->delete($product);

        $this->assertTrue($pdoSpy->beginTransactionCalled);
        $this->assertTrue($pdoSpy->commitCalled);

        $this->assertTrue($result);
    }

    public function testDeleteProductFailed()
    {
        $this->expectException(ProductException::class);
        $this->expectExceptionMessage('The product(Shoes) was not deleted');

        $product = new Product('Shoes', 69.9, 0, 1);

        $pdoSpy = new PDOSpy();
        $pdoSpy->failureOnWrite = true;

        $repository = new ProductRepository($pdoSpy);

        $repository->delete($product);
    }

    public function testUpdateProductSuccessful()
    {
        $product = new Product('Shoes', 79.9, 0, 1);

        $pdoSpy = new PDOSpy();

        $repository = new ProductRepository($pdoSpy);

        $this->assertTrue($repository->update($product));

        $this->assertTrue($pdoSpy->beginTransactionCalled);
        $this->assertTrue($pdoSpy->commitCalled);
    }

    public function testUpdateProductFailed()
    {
        $this->expectException(ProductException::class);
        $this->expectExceptionMessage('The product(Shoes) was not updated');

        $product = new Product('Shoes', 79.9, 0, 1);

        $pdoSpy = new PDOSpy();
        $pdoSpy->failureOnWrite = true;

        $repository = new ProductRepository($pdoSpy);

        $repository->update($product);
    }
}
