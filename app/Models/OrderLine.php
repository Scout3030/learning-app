<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderLine
 *
 * @property int $id
 * @property int $order_id
 * @property int $course_id
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Order $order
 */
class OrderLine extends Model
{
    protected $fillable = ['course_id', 'order_id', 'price'];

    protected $appends = [
        "formatted_price"
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function course() {
        return $this->belongsTo(Course::class);
    }
}
