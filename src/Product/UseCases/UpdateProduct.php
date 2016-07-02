<?php

namespace Develop\Business\Product\UseCases;

use Develop\Business\Product\Events\ProductStockHasIncreased;
use Develop\Business\Product\Events\ProductWasUpdated;
use Develop\Business\Product\Exceptions\ProductException;
use Develop\Business\Product\Factory as ProductFactory;
use Develop\Business\Product\Intentions\Intention;
use Develop\Business\Product\Intentions\IdentifiedIntention;
use Develop\Business\Product\Product;
use Develop\Business\Product\Repositories\Product as ProductRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

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
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param ProductRepository $repository
     * @param ProductFactory $factory
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(ProductRepository $repository, ProductFactory $factory, EventDispatcherInterface $eventDispatcher)
    {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->eventDispatcher = $eventDispatcher;
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
     * @param IdentifiedIntention $intention
     * @return Product
     * @throws ProductException
     */
    private function updateProduct(IdentifiedIntention $intention)
    {
        $product = $this->repository->find($intention->getId());

        $productDirty = $this->factory->createFromIntentionIdentified($intention);

        $updatedProduct = $product->merge($productDirty);

        $this->repository->update($updatedProduct);

        $this->eventDispatcher->dispatch(ProductWasUpdated::NAME, new ProductWasUpdated($updatedProduct));

        if ($this->isStockIncreased($product, $updatedProduct)) {
            $this->eventDispatcher->dispatch(ProductStockHasIncreased::NAME, new ProductStockHasIncreased($updatedProduct));
        }

        return $updatedProduct;
    }

    /**
     * @param Product $product
     * @param Product $updatedProduct
     * @return bool
     */
    private function isStockIncreased(Product $product, Product $updatedProduct)
    {
        return $updatedProduct->getStock() > 0 && $updatedProduct->getStock() > $product->getStock();
    }
}
