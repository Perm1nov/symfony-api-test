<?php

namespace App\Interfaces;

use App\Entity\Address;

interface AddressRepositoryInterface
{
    public function save(Address $entity): void;
    public function remove(Address $entity): void;
}
