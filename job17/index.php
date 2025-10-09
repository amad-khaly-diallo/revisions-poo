<?php
require __DIR__ . '/vendor/autoload.php';

use Khalyamad\Job15\Clothing;
use Khalyamad\Job15\Electronic;

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

echo "<h2>La méthode save() a été appelée pour le T-shirt</h2>";
echo "<pre>";
var_dump($shirt->save($shirt->getId()));
echo "</pre>";

$phone = new Electronic(
    "Smartphone XYZ",
    ["https://picsum.photos/201"],
    499.99,
    "Smartphone avec écran HD",
    15,
    null,
    null,
    2,
    "BrandY",
    24
);
echo "<h2>La méthode save() a été appelée pour le Smartphone</h2>";
echo "<pre>";
var_dump($phone->save($phone->getId()));
echo "</pre>";