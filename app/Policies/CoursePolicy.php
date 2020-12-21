<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function purchaseCourse (User $user, Course $course) {
        $isTeacher = $user->id === $course->user_id;
        $coursePurchased = $course->students->contains($user->id);
        return !$isTeacher && !$coursePurchased;
    }

    public function review (User $user, Course $course) {
        $coursePurchased = $course->students->contains($user->id);
        $reviewed = $course->reviews->contains('user_id', $user->id);
        return $coursePurchased && !$reviewed;
    }
}
