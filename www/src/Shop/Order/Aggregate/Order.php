<?php

namespace Shop\Order\Aggregate;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Shop\Order\Command\Checkout;
use Shop\Order\Command\CreateOrder;
use Shop\Order\Event\OrderConfirmed;
use Shop\Order\Event\OrderCreated;
use Shop\Order\Event\OrderPaymentRequested;
use Shop\Order\Exception\CheckoutDenied;
use Shop\Product\Command\CreateProduct;
use Shop\Product\Command\DeleteProduct;
use Shop\Product\Command\UpdateProduct;
use Shop\Product\Event\ProductCreated;
use Shop\Product\Event\ProductDeleted;
use Shop\Product\Event\ProductUpdated;

class Order extends EventSourcedAggregateRoot
{
    private $id;

    /**
     * @var \DateTimeImmutable
     */
    private $confirmedAt;

    public static function create(CreateOrder $command)
    {
        $product = new self();
        $product->apply(
            new OrderCreated(
                $command->getOrderId(),
                $command->getTotalCost(),
                $command->getItems(),
                $command->getCreatedAt()
            )
        );

        return $product;
    }

    public function checkout(Checkout $command)
    {
        if($this->confirmedAt) {
            throw new CheckoutDenied();
        }

        $this->apply(new OrderPaymentRequested(
            $command->getOrderId(),
            $command->getTotalCost(),
            $command->getRequestedAt()
        ));
    }

    protected function applyOrderCreated(OrderCreated $event)
    {
        $this->id = $event->getOrderId();
    }

    protected function applyOrderConfirmed(OrderConfirmed $event)
    {
        $this->confirmedAt = $event->getConfirmedAt();
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return $this->id;
    }
}
