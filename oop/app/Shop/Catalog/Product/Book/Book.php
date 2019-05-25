<?php

namespace Shop\Catalog\Product\Book;

use Shop\Catalog\Product;

abstract class Book extends Product
{
    /**
     * @var string
     */
    protected $author;

    public function __construct(string $name, float $price, string $author)
    {
        parent::__construct($name, $price);
        $this->author = $author;
    }

    public function setAuthor(string $author) : void
    {
        $this->author = $author;
    }

    public function getAuthor() : string
    {
        return $this->author;
    }

    abstract public function getSummaryLine();
}