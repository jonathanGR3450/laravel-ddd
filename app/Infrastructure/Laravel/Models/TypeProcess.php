<?php

namespace App\Infrastructure\Laravel\Models;

use App\Infrastructure\Laravel\Models\Process;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeProcess extends Model
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
        'updated_at',
    ];

    public function process()
    {
        return $this->hasMany(Process::class);
    }
}
