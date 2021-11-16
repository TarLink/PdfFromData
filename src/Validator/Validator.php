<?php

namespace Glfromd\Validator;

use Symfony\Component\Validator\Validation;
use ZipCodeValidator\Constraints\ZipCode;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use Glfromd\Model\Address;

class Validator
{
    private $address;

    public function __construct(Address $address)
    {
        $this->address = $address;
    }

    /**
     * Validate the input values
     *
     * @return array
     */
    public function validate(): array
    {
        $errors = [];

        //Mathias d'Arras
        //Martin Luther King, Jr.
        //Hector Sausage-Hausen
        if(!preg_match('/^[a-z ,.\'-]{1,25}$/i', $this->address->getFirstname())){
            $errors[] = "Firstname {$this->address->getFirstname()} has invalid characters or invalid length.";
        }

        if(!preg_match('/^[a-z ,.\'-]{1,25}$/i', $this->address->getLastname())){
            $errors[] = "Lastname {$this->address->getLastname()} has invalid characters or invalid length.";
        }

        //the name of a company can by quite complex, here we check only length
        if(!preg_match('/^.{2,25}$/i', $this->address->getCompanyName())){
            $errors[] = "Company name {$this->address->getCompanyName()} has invalid length.";
        }

        if(!preg_match('/^.{2,100}$/i', $this->address->getStreetAddress1())){
            $errors[] = "Street address 1 {$this->address->getStreetAddress1()} has invalid length.";
        }

        if(!preg_match('/^.{2,100}$/i',  $this->address->getStreetAddress2())){
            $errors[] = "Street address 2 {$this->address->getStreetAddress2()} has invalid length.";
        }

        /*
        The list of cities it accepts:
        Toronto
        St. Catharines
        San Fransisco
        Val-d'Or
        Presqu'ile
        Niagara on the Lake
        Niagara-on-the-Lake
        München
        toronto
        toRonTo
        villes du Québec
        Provence-Alpes-Côte d'Azur
        Île-de-France
        Kópavogur
        Garðabær
        Sauðárkrókur
        Þorlákshöfn

        also Antarctica (the territory South of 60 deg S)
        */
        if(!preg_match("/^([a-z0-9\u0080-\u024F\(\)]+(?:. |-| |')*[a-z0-9\u0080-\u024F\(\)]*){2,25}$/i",  $this->address->getCity())){
            $errors[] = "City {$this->address->getCity()} has invalid characters or invalid length.";
        }

        if(!preg_match("/^([a-z0-9\u0080-\u024F\(\)]+(?:. |-| |')*[a-z0-9\u0080-\u024F\(\)]*){2,25}$/i", $this->address->getState())){
            $errors[] = "State {$this->address->getState()} has invalid characters or invalid length.";
        }

        $validator = Validation::createValidator();
        $zipViolations = $validator->validate($this->address->getZip(), [
            new ZipCode(array(
                       'iso' => 'US'
                   ))
        ]);

        if (0 !== count($zipViolations)) {
            foreach ($zipViolations as $zipViolation) {
                $errors[] = $zipViolation->getMessage();
            }
        }

        //international zip codes are quite complex; todo: use external library
        // if(!preg_match('/^[a-z0-9 -]{2,10}$/i', $this->values['zip'])){
        //     $errors[] = "Zip code {$this->values['zip']} has invalid characters or invalid length.";
        // }

        if(!preg_match("/^([a-z0-9\u0080-\u024F\(\)]+(?:. |-| |')*[a-z0-9\u0080-\u024F\(\)]*){2,25}$/i", $this->address->getCountry())){
            $errors[] = "Country {$this->address->getCountry()} has invalid characters or invalid length.";
        }

        //phone numbers can contain a number of special characters; there are standard formats for each country but can not trust users to input in those formats
        if(!preg_match('/^.{2,15}$/i', $this->address->getPhone())){
            $errors[] = "Phone number {$this->address->getPhone()} has invalid length.";
        }

        //here I could of used the Symfony validator, but this package is potentially more rich in features; the price is a fatter package
        $validator = new EmailValidator();
        if(!$validator->isValid($this->address->getEmail(), new RFCValidation())){
            $errors[] = "Email {$this->address->getEmail()} is invalid.";
        };

        // //todo: use external library
        // if(!preg_match('/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i', $this->values['email'])){
        //     $errors[] = "Email {$this->values['email']} has invalid characters, invalid format or invalid length.";
        // }

        return $errors;
    }
}
