<?php

namespace App\Infrastructure\Laravel\Models\Vinculation;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'business_name',
        'phone',
        'nit',
        'address',
        'department',
        'city',
        'type_person',
        'city_register',
        'email',
        'expiration_date',
        'updated_at',
    ];

    public function process()
    {
        return $this->hasMany(Process::class);
    }
}
