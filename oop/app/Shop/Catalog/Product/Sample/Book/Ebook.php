<?php

namespace Shop\Catalog\Product\Sample\Book;

use Shop\Catalog\Product\Sample\Sample;
use Shop\Catalog\ProductInterface;
use Shop\Catalog\Product\Book\Ebook as FullEbook;

class Ebook extends Sample
{
    /**
     * @var FullEbook
     */
    protected $fullVersion;

    /**
     * Constructor override - makes sure that the full version of this sample is an ebook.
     *
     * @param string $name
     * @param float $price
     * @param FullEbook $fullVersion
     */
    public function __construct(string $name, float $price, FullEbook $fullVersion)
    {
        parent::__construct($name, $price, $fullVersion);
    }

    public function getFullVersion() : ProductInterface
    {
        return $this->fullVersion;
    }
}