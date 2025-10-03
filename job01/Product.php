<?php 
 class Product {
    private $id;
    private $name;
    private $photos;
    private $price;
    private $description;
    private $quantity;
    private $createdAt;
    private $updatedAt;

    public function __construct($id, $name, $photos, $price, $description, $quantity, $createdAt, $updatedAt)
    {
        $this -> id = $id;
        $this -> name = $name;
        $this -> photos = $photos;
        $this -> price = $price;
        $this -> description = $description;
        $this -> quantity = $quantity;
        $this -> createdAt = $createdAt;
        $this -> updatedAt = $updatedAt;
    }
    // product id
    public function getProductId(){
        return $this->id;
    }
    public function setProductId($newId){
        $this->id = $newId;
    }
    // product name
    public function getProductName(){
        return $this -> name;
    }
    public function setProductName($name){
        $this -> name = $name;
    }
    // product photos
    public function getProductPhotos(){
        return $this -> photos;
    }
    public function setProductPhotos($photos) {
        $this -> photos = $photos;
    }
    // product price
    public function getProductPrice(){
        return $this -> price;  
    }
    public function setProductPrice($price){
        $this -> price = $price;
    }
    // product description
    public function getProductDescription(){
        return $this -> description;
    }
    public function setProductDescription($description){
        $this -> description = $description;
    }
    // product quantity
    public function getProductQuantity(){
        return $this -> quantity;
    }
    public function setProductQuantity($quantity){
        $this -> quantity = $quantity;
    }
    // product created at
    public function getProductCreatedAt(){
        return $this -> createdAt;
    }
    public function setProductCreatedAt($createdAt){
        $this -> createdAt = $createdAt;
    }
    // product updated at
    public function getProductUpdatedAt(){
        return $this -> updatedAt;
    }
    public function setProductUpdatedAt($updatedAt){
        $this -> updatedAt = $updatedAt;
    }
 }
