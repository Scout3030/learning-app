<?php

namespace App\Http\Middleware;

use Closure;

class CanAccessToCourseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $blockAccess = false;
        if (!auth()->check()) $blockAccess = true;
        $course = $request->route()->parameter('course');
        $isTeacher = auth()->id() === $course->user_id;
        $coursePurchased = $course->student->contains(auth()->id());
        if (!$isTeacher && !$coursePurchased) $blockAccess = true;

        if ($blockAccess) {
            session()->flash("message", ["danger", __("No puedes acceder a este curso")]);
            return redirect(route("courses.show", ["course" => $course]));
        }
        return $next($request);
    }
}
