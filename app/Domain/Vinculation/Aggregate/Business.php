<?php

declare(strict_types=1);

namespace App\Domain\Vinculation\Aggregate;

use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\Shared\ValueObjects\Id;
use App\Domain\Vinculation\ValueObjects\Address;
use App\Domain\Vinculation\ValueObjects\BusinessName;
use App\Domain\Vinculation\ValueObjects\City;
use App\Domain\Vinculation\ValueObjects\CityRegister;
use App\Domain\Vinculation\ValueObjects\Department;
use App\Domain\Vinculation\ValueObjects\Email;
use App\Domain\Vinculation\ValueObjects\Nit;
use App\Domain\Vinculation\ValueObjects\Phone;
use App\Domain\Vinculation\ValueObjects\TypePerson;

final class Business
{
    private function __construct(
        private Id $id,
        private BusinessName $business_name,
        private Phone $phone,
        private Nit $nit,
        private Address $address,
        private Department $department,
        private City $city,
        private TypePerson $type_person,
        private CityRegister $city_register,
        private Email $email,
        private DateTimeValueObject $created_at,
        private ?DateTimeValueObject $expiration_date,
        private ?DateTimeValueObject $updated_at
    ) {
    }

    public static function create(
        Id $id,
        BusinessName $business_name,
        Phone $phone,
        Nit $nit,
        Address $address,
        Department $department,
        City $city,
        TypePerson $type_person,
        CityRegister $city_register,
        Email $email,
        DateTimeValueObject $created_at,
        ?DateTimeValueObject $expiration_date = null,
        ?DateTimeValueObject $updated_at = null
    ): self {
        return new self(
            $id,
            $business_name,
            $phone,
            $nit,
            $address,
            $department,
            $city,
            $type_person,
            $city_register,
            $email,
            $created_at,
            $expiration_date,
            $updated_at
        );
    }

    /**
     * Get the value of id
     */
    public function id(): Id
    {
        return $this->id;
    }

    /**
     * Get the value of business_name
     */
    public function businessName(): BusinessName
    {
        return $this->business_name;
    }

    /**
     * Set the value of business_name
     *
     * @return  self
     */
    public function updateBusinessName($business_name): self
    {
        $this->business_name = $business_name;

        return $this;
    }

    /**
     * Get the value of phone
     */
    public function phone(): Phone
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */
    public function updatePhone($phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of nit
     */
    public function nit(): Nit
    {
        return $this->nit;
    }

    /**
     * Set the value of nit
     *
     * @return  self
     */
    public function updateNit($nit): self
    {
        $this->nit = $nit;

        return $this;
    }

    /**
     * Get the value of address
     */
    public function address(): Address
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */
    public function updateAddress($address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of department
     */
    public function department(): Department
    {
        return $this->department;
    }

    /**
     * Set the value of department
     *
     * @return  self
     */
    public function updateDepartment($department): self
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get the value of city
     */
    public function city(): City
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */
    public function updateCity($city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of type_person
     */
    public function typePerson(): TypePerson
    {
        return $this->type_person;
    }

    /**
     * Set the value of type_person
     *
     * @return  self
     */
    public function updateTypePerson($type_person): self
    {
        $this->type_person = $type_person;

        return $this;
    }

    /**
     * Get the value of city_register
     */
    public function cityRegister(): CityRegister
    {
        return $this->city_register;
    }

    /**
     * Set the value of city_register
     *
     * @return  self
     */
    public function updateCityRegister($city_register): self
    {
        $this->city_register = $city_register;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function updateEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of expiration_date
     */
    public function expirationDate(): ?DateTimeValueObject
    {
        return $this->expiration_date;
    }

    /**
     * Set the value of expiration_date
     *
     * @return  self
     */
    public function updateExpirationDate($expiration_date): self
    {
        $this->expiration_date = $expiration_date;

        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function createdAt(): DateTimeValueObject
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     */
    public function updatedAt(): ?DateTimeValueObject
    {
        return $this->updated_at;
    }

    public function asArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'business_name' => $this->businessName()->value(),
            'phone' => $this->phone()->value(),
            'nit' => $this->nit()->value(),
            'address' => $this->address()->value(),
            'department' => $this->department()->value(),
            'city' => $this->city()->value(),
            'type_person' => $this->typePerson()->value(),
            'city_register' => $this->cityRegister()->value(),
            'email' => $this->email()->value(),
            'expiration_date' => $this->expirationDate()?->value(),
            'created_at' => $this->createdAt()->value(),
            'updated_at' => $this->updatedAt()?->value(),
        ];
    }
}
