<?php

namespace Model;

class PlacedOrder extends Model
{
    public function addAndGetPlacedOrder(int $total, string $email, string $phone, string $userName, string $address, string $city, string $country, string $postal)
    {
        $statement = self::getPdo()->prepare("INSERT INTO placed_orders (total, email, phone, name, address, city, country, postal) VALUES (:total, :email, :phone, :userName, :address, :city, :country, :postal)");
        $statement->execute(['total' => $total, 'email' => $email, 'phone' => $phone, 'userName' => $userName, 'address' => $address, 'city' => $city, 'country' => $country, 'postal' => $postal]);

        return self::getPdo()>lastInsertId();
    }
}