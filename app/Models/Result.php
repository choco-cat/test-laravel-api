<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Result extends Model
{
    use HasFactory;

    public bool $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected array $fillable = [
        'member_id',
        'milliseconds'
    ];

    /**
     * Relation with Member
     *
     * @return BelongsTo
     */
    public function members(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
