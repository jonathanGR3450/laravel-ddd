<?php

namespace App\Infrastructure\Laravel\Models\Vinculation;

use App\Domain\Shared\State\ProcessState;
use App\Infrastructure\Laravel\Models\TypeProcess;
use App\Infrastructure\Laravel\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates;

class Process extends Model
{
    use HasFactory, HasUuids, HasStates;

    protected $casts = [
        'state' => ProcessState::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'type_process_id',
        'state',
        'user_id',
        'business_id',
        'updated_at',
    ];

    public function typeProcess()
    {
        return $this->belongsTo(TypeProcess::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function archives()
    {
        return $this->hasMany(Archive::class);
    }
}
