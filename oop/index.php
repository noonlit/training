<?php

require_once 'autoload.php';

use Shop\Catalog\Product;
use Shop\Catalog\Product\Book\Audiobook;
use Shop\Catalog\Product\Sample\Book\Audiobook as AudiobookSample;
use Shop\Catalog\Product\Sample\Book\Ebook as EbookSample;
use Shop\Catalog\Product\Book\Ebook;
use Shop\Catalog\Product\Book\PhysicalBook as Book;
use Shop\Checkout\Cart;
use Shop\Wishlist\Wishlist;


/*******************************************
 * Create a bunch of products to work with *
 *******************************************/
$definitelyAProduct = new Product('A Mystery Wrapped in an Enigma', 0.5);
$physicalBook1      = new Book('The Haunting of Hill House', 15.99, 'Shirley Jackson', 'hardcover');
$physicalBook2      = new Book('Witches Abroad', 10.99, 'Terry Pratchett', 'paperback', 320);
$ebook              = new Ebook('Something Wicked This Way Comes', 7.02, 'Ray Bradbury', 'pdf');
$audiobook          = new Audiobook('The Song of Achilles', 10.95,'Madeline Miller', 690);
$audiobookSample    = new AudiobookSample('The Song of Achilles Sample', 0, $audiobook, 5);
$ebookSample        = new EbookSample('Something Wicked This Way Comes Sample', 0, $ebook);


/*************************************
 * Add some products to the wishlist *
 *************************************/
$wishlist = new Wishlist();
$wishlist->addItem($definitelyAProduct);
$wishlist->addItem($physicalBook1);


/*****************************************
 * Get some samples, because we're broke *
 *****************************************/
$cart = new Cart();
$cart->addItem($audiobookSample);
$cart->addItem($ebookSample);

echo "Total items: " . count($cart) . "\n";

// check out some static methods
$cart->removeItem($audiobookSample->getId());
echo "Removed items: " . Cart::getRemovedProductsCount() . "\n";

$cart->removeAllItems();
echo "Removed items: " . Cart::getRemovedProductsCount() . "\n";

$differentCart   = new Cart();
$differentEbook  = new Ebook('Norse Mythology', 11.89, 'Neil Gaiman', 'epub');
$differentEbook1 = new Ebook('Space Opera', 13.59, 'Catherynne Valente', 'mobi');
$differentCart->addItem($differentEbook);
$differentCart->addItem($differentEbook1);
$differentCart->removeAllItems();
echo "Removed items: " . Cart::getRemovedProductsCount() . "\n";


/**********************************************************************
 * Add some items to the cart, because we're not that broke after all *
 **********************************************************************/
$cart->addItem($physicalBook1);
$cart->addItem($physicalBook2);
$cart->addItem($ebook);
$cart->addItem($audiobook);
$cart->addItem($audiobookSample);


/*****************
 * ... or are we *
 *****************/
echo $cart->getTotal() . "\n";
$cart->increaseQty($physicalBook1->getId(), 10);
$cart->decreaseQty($physicalBook1->getId(), 2);
$cart->decreaseQty($ebook->getId(), 1);


/************************************************************
 * Check the play lengths of the audio products in the cart *
 ************************************************************/
$audioItems = array($audiobook, $audiobookSample);

foreach ($audioItems as $audioItem) {
    echo $audioItem->getPlayLength() . "\n";
}


/*******************************************************
 * We implemented Iterator, so we can iterate the cart *
 *******************************************************/
foreach ($cart as $item) {
    echo $item[Cart::ITEM_INDEX]->getId() . "\n";
}


/********************************************************************************************
 * We implemented JsonSerializable, so we can get a JSON-encoded representation of the cart *
 ********************************************************************************************/
echo json_encode($cart) . "\n";


/*********************************************
 * Let's see how our __call() method behaves *
 **********************************************/
echo $ebookSample->getFullVersionPrice();
echo $ebookSample->getTest();


/*********************************************
 * Let's see how our __clone() method behaves *
 *********************************************/
$ebookCopy = clone $ebook;


/*************************************************
 * Setting properties dynamically (please don't) *
 *************************************************/
$ebookCopy->words = 1000;
$ebook->words = 50000;


/*********************************************
 * The Cart class has implemented __invoke() *
 *********************************************/
$cart($ebookCopy);

// let's not abruptly exit debug mode
$endScript = null;