<?php

namespace App\Infrastructure\Laravel\Models;

use App\Infrastructure\Laravel\Models\Document;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'document_id',
        'type_archive',
        'path',
        'name_now',
        'name_previous',
        'process_id',
        'updated_at',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function process()
    {
        return $this->belongsTo(Process::class);
    }
}
