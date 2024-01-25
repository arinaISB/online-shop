<?php

namespace Model;

class PlacedOrder extends Model
{
    private int $id;
    private int $total;
    private string $email;
    private string $phone;
    private string $userName;
    private string $address;
    private string $city;
    private string $country;
    private string $postal;

    public function __construct(int $id, int $total, string $email, string $phone, string $userName, string $address, string $city, string $country, string $postal)
    {
        $this->id = $id;
        $this->total = $total;
        $this->email = $email;
        $this->phone = $phone;
        $this->userName = $userName;
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
        $this->postal = $postal;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getPostal(): string
    {
        return $this->postal;
    }

    public static function addAndGetPlacedOrder(int $total, string $email, string $phone, string $userName, string $address, string $city, string $country, string $postal): false|string
    {
        $statement = self::getPdo()->prepare("INSERT INTO placed_orders (total, email, phone, name, address, city, country, postal) VALUES (:total, :email, :phone, :userName, :address, :city, :country, :postal)");
        $statement->execute(['total' => $total, 'email' => $email, 'phone' => $phone, 'userName' => $userName, 'address' => $address, 'city' => $city, 'country' => $country, 'postal' => $postal]);

        return static::getPdo()->lastInsertId();
    }
}