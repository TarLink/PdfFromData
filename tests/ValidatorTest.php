<?php

namespace Glfromd\Tests;

use PHPUnit\Framework\TestCase;
use Faker;
use Glfromd\Model\Address;
use Glfromd\Validator\Validator;

class ValidatorTest extends TestCase
{
    protected $faker;
    protected ?Address $address;
    protected ?Address $badAddress;
    protected ?Validator $validator;
    protected $errorsG;
    protected $errorsB;

    protected function setUp(): void
    {
        $this->faker = Faker\Factory::create();
        $this->address = new Address();
        $this->address->setFirstname($this->faker->firstName());
        $this->address->setLastname($this->faker->lastName());
        $this->address->setCompanyName($this->faker->company());
        $this->address->setStreetAddress1($this->faker->streetAddress());
        $this->address->setStreetAddress2($this->faker->streetAddress());
        $this->address->setCity($this->faker->city());
        $this->address->setState($this->faker->state());
        $this->address->setZip($this->faker->postcode());
        $this->address->setCountry($this->faker->country());
        $this->address->setPhone($this->faker->e164PhoneNumber());
        $this->address->setEmail($this->faker->email());

        $this->badAddress = new Address();
        $this->badAddress->setFirstname($this->faker->regexify('[@#!]{20}'));
        $this->badAddress->setLastname($this->faker->regexify('[@#!]{20}'));
        $this->badAddress->setCompanyName($this->faker->regexify('[@#!]{40}'));
        $this->badAddress->setStreetAddress1($this->faker->regexify('[@#!]{200}'));
        $this->badAddress->setStreetAddress2($this->faker->regexify('[@#!]{200}'));
        $this->badAddress->setCity($this->faker->regexify('[@#!]{20}'));
        $this->badAddress->setState($this->faker->regexify('[@#!]{20}'));
        $this->badAddress->setZip($this->faker->regexify('[@#!]{8}'));
        $this->badAddress->setCountry($this->faker->regexify('[@#!]{20}'));
        $this->badAddress->setPhone($this->faker->regexify('[@#!]{20}'));
        $this->badAddress->setEmail($this->faker->regexify('[@#!]{20}'));

        $this->errorsG = [];
        $this->errorsB = [];
    }

    protected function tearDown(): void
    {
        $this->faker = null;
        $this->address = null;
        $this->badAddress = null;
        $this->errorsG = null;
        $this->errorsB = null;
    }

    public function testValidateGoodAddress()
    {
        $this->validator = new Validator($this->address);
        $this->errorsG = $this->validator->validate();
        if((strlen($this->address->getCompanyName()) >= 2) && (strlen($this->address->getCompanyName()) <= 25)){
            $this->assertEmpty($this->errorsG,"There are validation errors.");
        }else{
            $this->assertCount(1,$this->errorsG);
            $cn = $this->address->getCompanyName();
            $this->assertEquals("Company name {$cn} has invalid length.",$this->errorsG[0],
                'The validation message is not the same for invalid country length');
        }
    }

    public function testValidateBadAddress()
    {
        $this->validator = new Validator($this->badAddress);
        $this->errorsB = $this->validator->validate();
        $this->assertCount(11,$this->errorsB,'The number of errors does not reflect all validation errors.');
    }
}
