<?php
namespace Shop\Util;

/**
 * http://php.net/manual/ro/language.oop5.traits.php
 */
trait IdentityTrait
{
    /**
     * Returns an unique id.
     *
     * @return string
     */
    public function generateId() : string
    {
        return uniqid();
    }
}