<?php

namespace Shop;

use Shop\Catalog\ProductInterface;

interface ProductCollectionInterface
{
    public function getId() : string;

    public function addItem(ProductInterface $product) : void;

    public function getItem(string $id) : ProductInterface;

    public function removeItem(string $id) : void;

    public function hasItem(string $id) : bool;

    public function getItemQty(string $id) : int;

    public function increaseQty(string $id, $qty) : void;

    public function decreaseQty(string $id, $qty) : void;

    public function getAllItems() : array;

    public function removeAllItems() : void;

    public function isEmpty() : bool;
}