<?php

namespace App\Models;

use Livewire\Wireable;

class CardProduct implements Wireable {
    public string $id;
    public string $title;
    public string $description;
    public string $price;
    public string $takeaway_price;

    public function __construct(string $id, string $title, string $description, string $price, string $takeaway_price)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->takeaway_price = $takeaway_price;
    }

    public function toLivewire()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'takeaway_price' => $this->takeaway_price
        ];
    }

    public static function fromLivewire($value): static
    {
        $id = $value['id'];
        $title = $value['title'];
        $description = $value['description'];
        $price = $value['price'];
        $takeaway_price = $value['takeaway_price'];

        return new static(id: $id, title: $title, description: $description, price: $price, takeaway_price: $takeaway_price);
    }
}