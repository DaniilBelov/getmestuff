<?php

namespace App\Bots;


class Product
{
    public $title, $url, $price, $delivery, $total;

    public function __construct($title, $url, $price, $delivery)
    {
        $this->title = $title;
        $this->url = $url;
        $this->price = $price;
        $this->delivery = $delivery;
        $this->total = $price + $delivery;
    }
}