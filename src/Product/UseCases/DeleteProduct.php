<?php

namespace Develop\Business\Product\UseCases;

use Develop\Business\Product\Exceptions\ProductException;
use Develop\Business\Product\Factory as ProductFactory;
use Develop\Business\Product\Intentions\IdentifiedIntention;
use Develop\Business\Product\Intentions\Intention;
use Develop\Business\Product\Product;
use Develop\Business\Product\Repositories\Product as ProductRepository;

class DeleteProduct implements UseCase
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
     * @param Intention $intention
     * @return Product
     */
    public function execute(Intention $intention)
    {
        return $this->deleteProduct($intention);
    }

    /**
     * @return Product
     * @throws ProductException
     */
    private function deleteProduct(IdentifiedIntention $intention)
    {
        $product = $this->repository->find($intention->getId());

        $this->repository->delete($product);

        return $product;
    }
}
