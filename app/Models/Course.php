<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Course
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $picture
 * @property string $description
 * @property float $price
 * @property int $featured
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $students
 * @property-read int|null $students_count
 * @property-read \App\Models\User $teacher
 */
class Course extends Model
{
    protected $fillable = [
      "user_id", "title", "description",
      "picture", "price", "featured", "status"
    ];

    const PUBLISHED = 1;
    const PENDING = 2;
    const REJECTED = 3;

    public function imagePath() {
        return sprintf('%s/%s', 'storage/courses', $this->picture);
    }

    /** Many to many, inverse relationship */
    public function categories (){
        return $this->belongsToMany(Category::class);
    }

    /** Many to many, with pivot table */
    public function students (){
        return $this->belongsToMany(User::class, "course_student");
    }

    public function teacher (){
        return $this->belongsTo(User::class, "user_id");
    }

    /** one to many */
    public function reviews (){
        $this->hasMany(Review::class);
    }
}
