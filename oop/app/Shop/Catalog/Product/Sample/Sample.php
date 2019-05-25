<?php
namespace Shop\Catalog\Product\Sample;

use Shop\Catalog\ProductInterface;
use Shop\Catalog\Product;

abstract class Sample extends Product implements SampleInterface
{
    /**
     * @var ProductInterface
     */
    protected $fullVersion;

    /**
     * Constructor override - makes sure that the full version of the current sample is set.
     *
     * @param string $name
     * @param float $price
     * @param ProductInterface $fullVersion
     */
    public function __construct(string $name, float $price, ProductInterface $fullVersion)
    {
        parent::__construct($name, $price);
        $this->fullVersion = $fullVersion;
    }

    /**
     * Returns the full version of the current product sample.
     *
     * @return ProductInterface
     */
    public function getFullVersion() : ProductInterface
    {
        return $this->fullVersion;
    }

    /**
     * Is triggered when inexistent/inaccessible methods are called on an instance of this class
     *
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $method, array $arguments)
    {
        // if the $method parameter is something like 'getFullVersionPrice',
        // build and call the getter for the price property of the full version of this sample
        $validMethodPrefix = 'getFullVersion';
        $methodStartsWithValidPrefix = substr($method, 0, strlen($validMethodPrefix)) == $validMethodPrefix;

        if (!$methodStartsWithValidPrefix) {
            return null; // or better, throw exception, but Razvan will tell you about those :)
        }

        // remove the 'FullVersion' portion so we end up with a method like getPrice()
        $method = str_replace('FullVersion', '', $method);

        // sanity check: does the full version have this method?
        if (!method_exists($this->fullVersion, $method)) {
            return null; // exception again
        }

        return call_user_func_array(array($this->fullVersion, $method), $arguments);
    }
}