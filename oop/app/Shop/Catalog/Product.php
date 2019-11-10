<?php

namespace Shop\Catalog;

use Shop\ShopObject as ShopObject;

class Product extends ShopObject implements ProductInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var float
     */
    protected $price;

    public function __construct(string $name, float $price)
    {
        $this->name  = $name;
        $this->price = $price;
    }

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setPrice(float $price) : void
    {
        $this->price = $price;
    }

    public function getPrice() : float
    {
        return $this->price;
    }

    public function __toString() : string
    {
        return serialize($this);
    }
}
