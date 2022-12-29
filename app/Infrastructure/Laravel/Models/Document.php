<?php

namespace App\Infrastructure\Laravel\Models;

use App\Infrastructure\Laravel\Models\Archive;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'description',
        'type_process_id',
        'updated_at',
    ];

    public function archives()
    {
        return $this->hasMany(Archive::class);
    }
}
