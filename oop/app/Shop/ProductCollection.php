<?php
namespace Shop;

use Shop\Util\IdentityTrait;
use Shop\Catalog\ProductInterface;

class ProductCollection implements ProductCollectionInterface, \Iterator, \Countable
{
    use IdentityTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * An array of the form array('item' => $productInstance, 'qty' => $productQty)
     *
     * @var array
     */
    protected $itemsData = array();

    /**
     * Item IDs are stored separately to simplify the Iterator methods implementation
     *
     * @var array
     */
    protected $itemIds = array();

    /**
     * The position is stored to help with the Iterator methods implementation
     *
     * @var int
     */
    protected $position = 0;

    /**
     * Constants used to keep track of current collection's items and their qtys
     */
    const ITEM_INDEX     = 'item';
    const ITEM_QTY_INDEX = 'qty';

    /**
     * Adds an unique ID to the collection.
     */
    public function __construct()
    {
        $this->id = $this->generateId();
    }

    /**
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * Adds an item's data to the collection.
     *
     * @param ProductInterface $product
     */
    public function addItem(ProductInterface $product) : void
    {
        $id = $product->getId();

        $this->itemsData[$id] = array(
            self::ITEM_INDEX     => $product,
            self::ITEM_QTY_INDEX => 1
        );

        $this->itemIds[] = $id;
    }

    /**
     * Retrieves the data for the item with the given ID
     *
     * @param string $id
     * @return ProductInterface
     */
    public function getItem(string $id): ProductInterface
    {
        return isset($this->itemsData[$id]) ? $this->itemsData[$id] : null;
    }

    /**
     * Removes the data for the item with the given ID from the current collection.
     *
     * @param string $id
     */
    public function removeItem(string $id) : void
    {
        if (!$this->hasItem($id)) {
            return;
        }

        // remove the item data
        unset($this->itemsData[$id]);

        // remove the item ID, too
        $index = array_search($id, $this->itemIds);

        if ($index === false) {
            return;
        }

        unset($this->itemIds[$index]);

        // prevent the array of IDs from having gaps, as this will mess up the iteration
        $this->itemIds = array_values($this->itemIds);
    }

    /**
     * Checks whether the item with the given ID exists in the current collection.
     *
     * @param string $id
     * @return bool
     */
    public function hasItem(string $id) : bool
    {
        return isset($this->itemsData[$id]);
    }

    /**
     * Retrieves the qty for the item with the given ID found in the current collection.
     *
     * @param string $id
     * @return int
     */
    public function getItemQty(string $id) : int
    {
        return isset($this->itemsData[$id][self::ITEM_QTY_INDEX]) ? $this->itemsData[$id][self::ITEM_QTY_INDEX] : 0;
    }

    /**
     * Increases the qty of the item with the given ID by the given qty.
     *
     * @param string $id
     * @param $qty
     */
    public function increaseQty(string $id, $qty) : void
    {
        if (!$this->hasItem($id)) {
            return;
        }

        $this->itemsData[$id][self::ITEM_QTY_INDEX] += $qty;
    }

    /**
     * Decreases the qty of the item with the given ID by the given qty.
     *
     * @param string $id
     * @param $qty
     */
    public function decreaseQty(string $id, $qty) : void
    {
        if (!$this->hasItem($id)) {
            return;
        }

        $this->itemsData[$id][self::ITEM_QTY_INDEX] -= $qty;

        if ($this->itemsData[$id][self::ITEM_QTY_INDEX] == 0) {
            $this->removeItem($id);
        }
    }

    /**
     * Returns all the items data in this collection
     *
     * @return array An array containing the product objects and their quantities
     */
    public function getAllItems(): array
    {
        return $this->itemsData;
    }

    /**
     * Removes all items from the collection.
     *
     * @return void
     */
    public function removeAllItems() : void
    {
        $this->itemsData = array();
        $this->itemIds   = array();
    }

    /**
     * Checks whether the collection is empty.
     *
     * @return bool
     */
    public function isEmpty() : bool
    {
        return empty($this->itemsData);
    }

    /**
     * Returns the current item.
     *
     * @return array
     */
    public function current() : array
    {
        $index = $this->itemIds[$this->position];
        return $this->itemsData[$index];
    }

    /**
     * Returns the current position.
     *
     * @return int
     */
    public function key() : int
    {
        return $this->position;
    }

    /**
     * Increments the current position.
     *
     * @return void
     */
    public function next() : void
    {
        $this->position++;
    }

    /**
     * Resets the current position to the start.
     *
     * @return void
     */
    public function rewind() : void
    {
        $this->position = 0;
    }

    /**
     * Checks whether a value is indexed at the current position.
     *
     * @return bool
     */
    public function valid() : bool
    {
        return (isset($this->itemIds[$this->position]));
    }

    /**
     * Returns the number of items in the cart.
     *
     * @return int
     */
    public function count() : int
    {
        return count($this->itemsData);
    }
}