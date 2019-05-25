<?php

namespace Shop\Catalog\Product;

interface AudioInterface
{
    public function setPlayLength(float $playLength) : void;
    public function getPlayLength() : float;
}