<?php

namespace Shop\Catalog\Product\Book;

class PhysicalBook extends Book
{
    /**
     * E.g. paperback, hardcover
     *
     * @var string
     */
    protected $format;

    /**
     * @var int|null
     */
    protected $pagesCount;

    public function __construct(string $name, float $price, string $author, string $format, $pagesCount = null)
    {
        parent::__construct($name, $price, $author);
        $this->format      = $format;
        $this->pagesCount  = $pagesCount;
    }

    public function getSummaryLine(): string
    {
        return '';
    }
}