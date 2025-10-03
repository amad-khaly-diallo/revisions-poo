<?php
require_once 'Product.php';
require_once 'config.php';


// instantiate a Product
$product = new Product("","Test product",["https://picsum.photos/200/300"],99.99,"This is a test product",10,new DateTime(),new DateTime(),1);
$newProduct = $product->create();


echo "<pre>";
echo "<h2> Afficher le produit créé </h2>";
var_dump($newProduct);
echo "</pre>";
