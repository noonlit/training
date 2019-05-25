<?php

namespace Shop\Checkout;

use Shop\ProductCollection;
use Shop\Catalog\ProductInterface;

class Cart extends ProductCollection implements \JsonSerializable
{
    /**
     * Static counter that keeps track of items removed from the cart
     *
     * @var int
     */
    protected static $removedItemsCounter = 0;

    public function removeItem($id) : void
    {
        parent::removeItem($id);

        self::$removedItemsCounter++;
    }

    public function removeAllItems() : void
    {
        $currentItemsCount = count($this->itemsData);
        self::$removedItemsCounter += $currentItemsCount;

        parent::removeAllItems();
    }

    public static function getRemovedProductsCount() : int
    {
        return self::$removedItemsCounter;
    }

    public function getTotal() : float
    {
        $total = 0;

        foreach ($this->itemsData as $itemArray) {
            /** @var ProductInterface $item */
            $item = $itemArray[self::ITEM_INDEX];
            $total += $item->getPrice();
        }

        return $total;
    }

    /**
     * Returns a representation of the current class instance as a JSON-encoded string
     *
     * @return string
     */
    public function jsonSerialize() : string
    {
        return json_encode($this->itemsData);
    }

    /**
     * Defines how instances of this class will react when called as functions
     *
     * @param ProductInterface $product
     * @return void
     */
    public function __invoke(ProductInterface $product) : void
    {
        $this->addItem($product);
    }
}