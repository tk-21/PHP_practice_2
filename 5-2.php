<?php

class Item {
    public $name;
    public $price;

    public function getPrice() {
        return number_format($this->price);
    }
}

$php_basic = new Item();
$php_basic->name = 'PHP入門';
$php_basic->price = 1500;

echo $php_basic->name, '/', $php_basic->getPrice();
