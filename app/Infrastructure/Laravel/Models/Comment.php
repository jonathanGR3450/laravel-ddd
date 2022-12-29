<?php

namespace App\Infrastructure\Laravel\Models;

use App\Domain\Shared\State\ProcessState;
use App\Infrastructure\Laravel\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates;

class Comment extends Model
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
        'comment',
        'process_id',
        'state',
        'user_id',
        'updated_at',
    ];

    public function process()
    {
        return $this->belongsTo(Process::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
