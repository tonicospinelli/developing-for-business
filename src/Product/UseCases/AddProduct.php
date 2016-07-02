<?php

namespace Develop\Business\Product\UseCases;

use Develop\Business\Product\Exceptions\ProductException;
use Develop\Business\Product\Exceptions\ProductExistsException;
use Develop\Business\Product\Exceptions\ProductNotFoundException;
use Develop\Business\Product\Factory as ProductFactory;
use Develop\Business\Product\Intentions\AddProduct as AddProductIntent;
use Develop\Business\Product\Product;
use Develop\Business\Product\Repositories\Product as ProductRepository;

class AddProduct
{
    /**
     * @var ProductRepository
     */
    private $repository;

    /**
     * @var ProductFactory
     */
    private $factory;

    /**
     * @param ProductRepository $repository
     * @param ProductFactory $factory
     */
    public function __construct(ProductRepository $repository, ProductFactory $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    /**
     * @param AddProductIntent $intent
     * @return Product
     * @throws ProductExistsException
     */
    public function execute(AddProductIntent $intent)
    {
        try {
            $product = $this->repository->findByName($intent->getName());
            throw ProductException::existsWithName($product->getName());
        } catch (ProductNotFoundException $e) {
            // do nothing
        }

        $product = $this->factory->createFromIntention($intent);

        return $this->repository->add($product);
    }
}
