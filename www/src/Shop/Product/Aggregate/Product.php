<?php

namespace Shop\Product\Aggregate;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Shop\Product\Command\CreateProduct;
use Shop\Product\Event\ProductCreated;

class Product extends EventSourcedAggregateRoot
{
    public static function create(CreateProduct $command)
    {
        $product = new self();
        $product->apply(
            new ProductCreated(
                $command->getProductId(),
                $command->getBarcode(),
                $command->getName(),
                $command->getImageurl(),
                $command->getBrand(),
                $command->getCreatedAt()
            )
        );

        return $product;
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        // TODO: Implement getAggregateRootId() method.
    }
}