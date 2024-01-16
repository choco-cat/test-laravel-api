<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

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

    /**
     * Get members top list
     * @param int $count
     * @return array|Collection
     */
    public static function getTop(int $count): array|Collection
    {
        return self::with('members')
            ->select('member_id', DB::raw('MIN(milliseconds) as milliseconds'))
            ->groupBy('member_id')
            ->orderBy('milliseconds')
            ->take($count)
            ->get();
    }
}
