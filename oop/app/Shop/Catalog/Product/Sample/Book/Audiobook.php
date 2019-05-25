<?php

namespace Shop\Catalog\Product\Sample\Book;

use Shop\Catalog\Product\Sample\Sample;
use Shop\Catalog\ProductInterface;
use Shop\Catalog\Product\Book\Audiobook as FullAudiobook;
use Shop\Catalog\Product\AudioInterface;

class Audiobook extends Sample implements AudioInterface
{
    /**
     * @var FullAudiobook
     */
    protected $fullVersion;

    /**
     * @var float Play length in minutes
     */
    protected $playLength;

    /**
     * Constructor override - makes sure that the full version of this sample is an audiobook and has a play length
     *
     * @param string $name
     * @param float $price
     * @param FullAudiobook $fullVersion
     * @param float $playLength
     */
    public function __construct(string $name, float $price, FullAudiobook $fullVersion, float $playLength)
    {
        parent::__construct($name, $price, $fullVersion);
        $this->playLength = $playLength;
    }

    public function getFullVersion() : ProductInterface
    {
        return $this->fullVersion;
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

}