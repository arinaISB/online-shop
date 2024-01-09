<?php

namespace Model;

class PlaceOrder extends Model
{
    public function addContactInfo(string $email, string $phone, string $name, string $address, string $city, string $country, string $postal)
    {
        $statement = $this->pdo->prepare("INSERT INTO contact_information (email, phone, name, address, city, country, postal) VALUES (:email, :phone, :name, :address, :city, :country, :postal)");
        $statement->execute(['email' => $email, 'phone' => $phone, 'name' => $name, 'address' => $address, 'city' => $city, 'country' => $country, 'postal' => $postal,]);
        $result = $statement->fetchAll();

        return $result;
    }
}