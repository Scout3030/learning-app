<?php

namespace App\Models;

use App\Traits\Hashidable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Unit
 *
 * @property int $id
 * @property int $user_id
 * @property int $course_id
 * @property int $order
 * @property string $unit_type
 * @property string $title
 * @property string|null $content
 * @property string|null $file
 * @property int $free
 * @property int|null $unit_time Total minutes if apply
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit whereFree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit whereUnitTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit whereUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Course $course
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit forTeacher()
 */
class Unit extends Model
{
    use Hashidable;

    protected $fillable = [
        "title", "content", "course_id", "user_id",
        "unit_type", "unit_time", "file", "order", "free"
    ];

    const ZIP = 'ZIP';
    const VIDEO = 'VIDEO';
    const SECTION = 'SECTION';

    protected static function boot()
    {
        parent::boot();

        /** on saving, create or store */
        self::saving(function ($table) {
            $table->user_id = auth()->id();
        });

        /** On create */
        self::creating(function ($table) {
            $last = Unit::whereCourseId(request("course_id"))
                ->orderBy('order', 'desc')
                ->take(1)
                ->first();
            $table->order = $last ? $last->order += 1 : 1;
        });
    }

    public function course () {
        return $this->belongsTo(Course::class);
    }

    public function scopeForTeacher(Builder $builder) {
        return $builder
            ->with('course')
            ->where('user_id', auth()->id())
            ->paginate();
    }

    public static function unitTypes() {
        return [
            self::ZIP, self::VIDEO, self::SECTION
        ];
    }
}
