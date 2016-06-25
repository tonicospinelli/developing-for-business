<?php

namespace Develop\Business\Product\UseCases;

use Develop\Business\Product\Exceptions\ProductException;
use Develop\Business\Product\Factory as ProductFactory;
use Develop\Business\Product\Intentions\Intention;
use Develop\Business\Product\Intentions\IntentionIdentified;
use Develop\Business\Product\Product;
use Develop\Business\Product\Repositories\Product as ProductRepository;

class UpdateProduct implements UseCase
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
        return $this->updateProduct($intention);
    }

    /**
     * @param IntentionIdentified $intention
     * @return Product
     * @throws ProductException
     */
    private function updateProduct(IntentionIdentified $intention)
    {
        $product = $this->repository->find($intention->getId());

        $productDirty = $this->factory->createFromIntentionIdentified($intention);

        $updatedProduct = $product->merge($productDirty);

        $this->repository->update($updatedProduct);

        return $updatedProduct;
    }
}
