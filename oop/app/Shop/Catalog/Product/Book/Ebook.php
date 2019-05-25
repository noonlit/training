<?php

namespace Shop\Catalog\Product\Book;

class Ebook extends Book
{
    /**
     * E.g. pdf, epub
     *
     * @var string
     */
    protected $format;

    public function __construct(string $name, float $price, string $author, string $format)
    {
        parent::__construct($name, $price, $author);
        $this->format = $format;
    }

    /**
     * @return string
     */
    public function getSummaryLine(): string
    {
        return "{$this->name} by {$this->author}: uniquely portable magic on all your devices, in an {$this->format} format";
    }
}