<?php

namespace App\Models;

use App\Traits\Hashidable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Coupon
 *
 * @property int $id
 * @property int $user_id
 * @property string $code
 * @property string $description
 * @property string $discount_type
 * @property int $enable
 * @property string|null $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Course[] $courses
 * @property-read int|null $courses_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon available($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon forTeacher()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon withoutTrashed()
 */
class Coupon extends Model
{
    use SoftDeletes, Hashidable;

    const PERCENT = 'PERCENT';
    const PRICE = 'PRICE';

    protected $fillable = [
        'user_id', 'code', 'discount_type',
        'discount', 'description', 'enabled', 'expires_at'
    ];

    protected $dates = [
        "expires_at"
    ];

    protected static function boot() {
        parent::boot();
        if (!app()->runningInConsole()) {
            self::saving(function ($table) {
                $table->user_id = auth()->id();
            });
        }
    }

    public function courses() {
        return $this->belongsToMany(Course::class);
    }

    public function scopeForTeacher(Builder $builder) {
        return $builder
            ->where("user_id", auth()->id())
            ->paginate();
    }

    public function scopeAvailable(Builder $builder, string $code) {
        return $builder
            ->where("enabled", true)
            ->where("code", $code)
            ->where('expires_at', '>=', now())
            ->orWhereNull('expires_at');
    }

    public static function discountTypes() {
        return [
            self::PERCENT => __("Porcentaje"),
            self::PRICE => __("Fijo"),
        ];
    }
}
