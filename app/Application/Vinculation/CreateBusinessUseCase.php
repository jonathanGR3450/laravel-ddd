<?php

declare(strict_types=1);

namespace App\Application\Vinculation;

use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\Shared\ValueObjects\Id;
use App\Domain\Vinculation\Aggregate\Business;
use App\Domain\Vinculation\BusinessRepositoryInterface;
use App\Domain\Vinculation\ValueObjects\Address;
use App\Domain\Vinculation\ValueObjects\BusinessName;
use App\Domain\Vinculation\ValueObjects\City;
use App\Domain\Vinculation\ValueObjects\CityRegister;
use App\Domain\Vinculation\ValueObjects\Department;
use App\Domain\Vinculation\ValueObjects\Email;
use App\Domain\Vinculation\ValueObjects\Nit;
use App\Domain\Vinculation\ValueObjects\Phone;
use App\Domain\Vinculation\ValueObjects\TypePerson;

final class CreateBusinessUseCase
{
    private BusinessRepositoryInterface $businessRepositoryInterface;

    public function __construct(BusinessRepositoryInterface $businessRepositoryInterface) {
        $this->businessRepositoryInterface = $businessRepositoryInterface;
    }

    public function __invoke(string $business_name, int $phone, int $nit, string $address, string $department, string $city, string $type_person, string $email, string $city_register): Business
    {
        $business = Business::create(
            Id::random(),
            BusinessName::fromString($business_name),
            Phone::fromInteger($phone),
            Nit::fromInteger($nit),
            Address::fromString($address),
            Department::fromString($department),
            City::fromString($city),
            TypePerson::fromString($type_person),
            CityRegister::fromString($city_register),
            Email::fromString($email),
            DateTimeValueObject::now()
        );

        $this->businessRepositoryInterface->create($business);

        return $business;
    }
}