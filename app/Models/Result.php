<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Result extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id',
        'milliseconds'
    ];

    /**
     * Relation with Member
     *
     * @return BelongsTo
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    /**
     * Get members top list
     * @param int|null $count
     * @return Collection
     */
    public static function getTop(?int $count): Collection
    {
        return self::queryWithBestMembersResults()
            ->when($count !== null, fn($query) => $query->take($count))
            ->get()
            ->map(fn($result, $index) => tap($result, fn($result) => $result->place = $index + 1));
    }

    /**
     * Adds members fields and grouping by members to the query
     *
     * @param string|null $email
     * @return Builder
     */
    public static function queryWithBestMembersResults(string $email = null): Builder
    {
        return self::with('member')
            ->select('member_id', DB::raw('MIN(milliseconds) as milliseconds'))
            ->whereNotNull('member_id')
            ->when($email !== null, fn($query) => $query->whereHas('member', fn($subquery) => $subquery->where('email', $email)))
            ->groupBy('member_id')
            ->orderBy('milliseconds');
    }
}
