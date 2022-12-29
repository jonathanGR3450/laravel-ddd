<?php

declare(strict_types=1);

namespace App\Infrastructure\Vinculation;

use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\Shared\ValueObjects\Id;
use App\Domain\User\Aggregate\User;
use App\Domain\Vinculation\Aggregate\Business;
use App\Domain\Vinculation\Aggregate\BusinessUser as AggregateBusinessUser;
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
use App\Infrastructure\Laravel\Models\Business as ModelBusiness;
use App\Infrastructure\Laravel\Models\BusinessUser;
use Exception;

class BusinessRepository implements BusinessRepositoryInterface
{

    public function create(Business $business): void
    {
        $userModel = new ModelBusiness();

        $userModel->id = $business->id()->value();
        $userModel->business_name = $business->businessName()->value();
        $userModel->phone = $business->phone()->value();
        $userModel->nit = $business->nit()->value();
        $userModel->address = $business->address()->value();
        $userModel->department = $business->department()->value();
        $userModel->city = $business->city()->value();
        $userModel->type_person = $business->typePerson()->value();
        $userModel->city_register = $business->cityRegister()->value();
        $userModel->email = $business->email()->value();
        $userModel->expiration_date = $business->expirationDate()?->value();
        $userModel->created_at = DateTimeValueObject::now()->value();

        $userModel->save();
    }

    public function createUserBusiness(AggregateBusinessUser $businessUser): void
    {
        $businessUserModel = new BusinessUser();
        $businessUserModel->id = $businessUser->id()->value();
        $businessUserModel->user_id = $businessUser->userId()->value();
        $businessUserModel->business_id = $businessUser->businessId()->value();
        $businessUserModel->created_at = DateTimeValueObject::now()->value();

        $businessUserModel->save();
    }

    public function findById(Id $id): Business
    {
        $businessModel = ModelBusiness::find($id->value());

        if (empty($businessModel)) {
            throw new Exception('business does not exist');
        }
        return self::map($businessModel);
    }

    public static function map(ModelBusiness $model): Business
    {
        return Business::create(
            Id::fromPrimitives($model->id),
            BusinessName::fromString($model->business_name),
            Phone::fromInteger($model->phone),
            Nit::fromInteger($model->nit),
            Address::fromString($model->address),
            Department::fromString($model->department),
            City::fromString($model->city),
            TypePerson::fromString($model->type_person),
            CityRegister::fromString($model->city_register),
            Email::fromString($model->email),
            DateTimeValueObject::fromPrimitives($model->created_at->__toString()),
            !empty($model->expiration_date) ? DateTimeValueObject::fromPrimitives($model->expiration_date) : null,
            !empty($model->updated_at) ? DateTimeValueObject::fromPrimitives($model->updated_at->__toString()) : null,
        );
    }
}