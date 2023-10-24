<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Address;
use App\Exceptions\PositionNotFoundException;
use App\Interfaces\AddressRepositoryInterface;

class AddressPositionService
{
    public function __construct(
        public GetAddressPositionService $positionService,
        public AddressRepositoryInterface $repository
    ) {
    }


    /**
     * @throws PositionNotFoundException
     */
    public function run(Address $address): void
    {
        $position = $this->positionService->run($address->getAddress());
        $address->setPosition($position);
        $this->repository->save($address);
    }
}
