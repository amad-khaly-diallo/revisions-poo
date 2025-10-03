<?php
require_once 'Product.php';
require_once 'config.php';


// instantiate a Product
$product = new Product();
echo "<pre>";
echo "<br>";
echo "<h2> Trouver un produit par son id </h2>";
var_dump($product->findOneById(17));
echo "</pre>";
