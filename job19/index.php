<?php
require __DIR__ . '/vendor/autoload.php';

use Khalyamad\Job15\Clothing;
use Khalyamad\Job15\Electronic;
use Khalyamad\Job15\EntityCollection;

$shirt = new Clothing(
    "T-shirt noir",
    ["https://picsum.photos/200/300"],
    19.99,
    "T-shirt 100% coton",
    10,
    null,
    null,
    1,
    "L",
    "Noir",
    "T-shirt",
    5
);

$collection = new EntityCollection();
$collection->add($shirt);
echo "<h2>La collection d'entités</h2>";
echo "<pre>";
var_dump($collection->retrieve());
echo "</pre>";
$collection->remove($shirt);
echo "<h2>La collection d'entités après suppression</h2>";
echo "<pre>";
var_dump($collection->retrieve());
echo "</pre>";  