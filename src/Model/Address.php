<?php

namespace Glfromd\Model;

class Address
{
    private $firstname;
    private $lastname;
    private $company_name;
    private $street_address_1;
    private $street_address_2;
    private $city;
    private $state;
    private $zip;
    private $country;
    private $phone;
    private $email;

    public function getFirstname(){
        return $this->firstname;
    }

    public function setFirstname($firstname){
        $this->firstname = $firstname;
    }

    public function getLastname(){
        return $this->lastname;
    }

    public function setLastname($lastname){
        $this->lastname = $lastname;
    }

    public function getCompanyName(){
        return $this->company_name;
    }

    public function setCompanyName($company_name){
        $this->company_name = $company_name;
    }

    public function getStreetAddress1(){
        return $this->street_address_1;
    }

    public function setStreetAddress1($street_address_1){
        $this->street_address_1 = $street_address_1;
    }

    public function getStreetAddress2(){
        return $this->street_address_2;
    }

    public function setStreetAddress2($street_address_2){
        $this->street_address_2 = $street_address_2;
    }

    public function getCity(){
        return $this->city;
    }

    public function setCity($city){
        $this->city = $city;
    }

    public function getState(){
        return $this->state;
    }

    public function setState($state){
        $this->state = $state;
    }

    public function getZip(){
        return $this->zip;
    }

    public function setZip($zip){
        $this->zip = $zip;
    }

    public function getCountry(){
        return $this->country;
    }

    public function setCountry($country){
        $this->country = $country;
    }

    public function getPhone(){
        return $this->phone;
    }

    public function setPhone($phone){
        $this->phone = $phone;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }
}
