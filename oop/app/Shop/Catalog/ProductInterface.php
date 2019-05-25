<?php

namespace Shop\Catalog;

interface ProductInterface
{
    public function getId() : string;

    public function setName(string $name) : void;

    public function getName() : string;

    public function setPrice(float $price) : void;

    public function getPrice() : float;
}