<?php

namespace Glfromd\UID;

use Glfromd\Model\Address;

class UID
{
    private Address $address;

    public function __construct($address)
    {
        $this->address = $address;
    }

    /**
     * Generate UID.
     *
     * @return string
     */
    public function generate(): string
    {
        $aggregate = $this->address->getFirstname() . $this->address->getLastname()
            . $this->address->getCompanyName() . $this->address->getStreetAddress1()
            . $this->address->getStreetAddress2() . $this->address->getCity()
            . $this->address->getState() . $this->address->getZip()
            .  $this->address->getCountry() . $this->address->getPhone() . $this->address->getEmail();

        return sha1($aggregate);
    }
}
