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
    public function getId(){
        return $this->id;
    }
    public function setId($newId){
        $this->id = $newId;
    }
    // product name
    public function getName(){
        return $this -> name;
    }
    public function setName($name){
        $this -> name = $name;
    }
    // product photos
    public function getPhotos(){
        return $this -> photos;
    }
    public function setPhotos($photos) {
        $this -> photos = $photos;
    }
    // product price
    public function getPrice(){
        return $this -> price;  
    }
    public function setPrice($price){
        $this -> price = $price;
    }
    // product description
    public function getDescription(){
        return $this -> description;
    }
    public function setDescription($description){
        $this -> description = $description;
    }
    // product quantity
    public function getQuantity(){
        return $this -> quantity;
    }
    public function setQuantity($quantity){
        $this -> quantity = $quantity;
    }
    // product created at
    public function getCreatedAt(){
        return $this -> createdAt;
    }
    public function setCreatedAt($createdAt){
        $this -> createdAt = $createdAt;
    }
    // product updated at
    public function getUpdatedAt(){
        return $this -> updatedAt;
    }
    public function setUpdatedAt($updatedAt){
        $this -> updatedAt = $updatedAt;
    }
 }
