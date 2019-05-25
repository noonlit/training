<?php

/**
 * http://php.net/manual/ro/language.namespaces.rationale.php
 */
namespace Shop;

use Shop\Util\IdentityTrait as IdentityTrait;

/**
 * http://php.net/manual/en/language.oop5.abstract.php
 */
abstract class ShopObject
{
    use IdentityTrait;

    /**
     * @var string id
     */
    protected $id;

    /**
     * ShopObject constructor.
     *
     * It will set the object's unique id at instantiation.
     *
     * Note: If you don't declare a constructor, the parent constructor is called implicitly.
     * If you do, you have to call the parent constructor yourself.
     */
    public function __construct()
    {
        $this->id = $this->generateId();
    }

    public function getId() : string
    {
        return $this->id;
    }

    /**
     * Magic methods coming up: http://php.net/manual/ro/language.oop5.magic.php
     */

    /**
     * Is called when a class instance is cloned
     */
    public function __clone()
    {
        $this->id = $this->generateId();
    }

    /**
     * Is called when a class instance is used as a string (e.g. echo $classInstance)
     *
     * @return string
     */
    abstract public function __toString();
}