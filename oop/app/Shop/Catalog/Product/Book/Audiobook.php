<?php

namespace Shop\Catalog\Product\Book;

use Shop\Catalog\Product\AudioInterface;

class Audiobook extends Book implements AudioInterface
{
    /**
     * @var float Play length in minutes
     */
    protected $playLength;

    /**
     * @param string $name
     * @param float $price
     * @param string $author
     * @param float $playLength Play length in minutes
     */
    public function __construct(string $name, float $price, string $author, float $playLength)
    {
        parent::__construct($name, $price, $author);
        $this->playLength = $playLength;
    }

    /**
     * @param float $playLength Play length in minutes
     */
    public function setPlayLength(float $playLength) : void
    {
        $this->playLength = $playLength;
    }

    public function getPlayLength() : float
    {
        return $this->playLength;
    }

    /**
     * @return string
     */
    public function getSummaryLine() : string
    {
        return "{$this->name} by {$this->author}: {$this->playLength} minutes of escape from cold reality.";
    }

}