<?php

namespace App\Models;

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
 */
class Unit extends Model
{
    const ZIP = 'ZIP';
    const VIDEO = 'VIDEO';
    const SECTION = 'SECTION';
}
