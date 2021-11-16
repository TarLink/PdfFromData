<?php

namespace Glfromd\Tests;

use PHPUnit\Framework\TestCase;
use Faker;
use Glfromd\Model\Address;
use Glfromd\UID\UID;

class UIDTest extends TestCase
{
    protected $faker;
    protected ?Address $address;
    protected ?Validator $validator;
    protected $errors;

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

        $this->errors = [];
    }

    protected function tearDown(): void
    {
        $this->faker = null;
        $this->address = null;
        $this->errors = null;
    }

    public function testGenerate()
    {
        $this->uid = new UID($this->address);
        $hash = $this->uid->generate();
        $aggregate = $this->address->getFirstname() . $this->address->getLastname()
            . $this->address->getCompanyName() . $this->address->getStreetAddress1()
            . $this->address->getStreetAddress2() . $this->address->getCity()
            . $this->address->getState() . $this->address->getZip()
            .  $this->address->getCountry() . $this->address->getPhone() . $this->address->getEmail();

        $testHash = sha1($aggregate);
        $this->assertEquals($hash,$testHash, 'The UID is not good');
    }
}
