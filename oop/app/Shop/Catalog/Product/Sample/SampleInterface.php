<?php

namespace Shop\Catalog\Product\Sample;

use Shop\Catalog\ProductInterface;

interface SampleInterface
{
    public function getFullVersion() : ProductInterface;
}