<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Member extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email'
    ];

    /**
     * Relation with Result
     *
     * @return HasMany
     */
    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'member_id', 'id');
    }

    /**
     * @param string|null $email
     * @return Model|null
     */
    public static function getUser(?string $email): Model|null
    {
        return self::where('email', $email)->first();
    }

    /**
     * Get best member result
     *
     * @return Model|null
     */
    public function getUserResult(): Model|null
    {
        return Result::queryWithBestMembersResults($this->email)
            ->get()
            ->map(fn($result, $index) => tap($result, fn($result) => $result->place = $this->getUserPlace()))
            ->first();
    }

    /**
     * Get user place
     *
     * @return int
     */
    private function getUserPlace(): int
    {
        return DB::table('results as r')
                ->join('members as m', 'm.id', '=', 'r.member_id')
                ->select(DB::raw('MIN(r.milliseconds) as result'), 'm.email', 'm.id')
                ->groupBy('m.id')
                ->havingRaw('MIN(r.milliseconds) < (SELECT MIN(r2.milliseconds) FROM results as r2 JOIN members as m2 ON m2.id = r2.member_id WHERE m2.email = ?)', [$this->email])
                ->count() + 1;
    }
}
