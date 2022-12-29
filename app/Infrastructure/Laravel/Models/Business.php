<?php

namespace App\Infrastructure\Laravel\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'business';

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

    public function users()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            User::class,
            'business_users',
            'business_id',
            'user_id'
        );
    }
}
