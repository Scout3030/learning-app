<?php

namespace App\Http\Controllers;

use App\Helpers\Currency;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::filtered();
        return view('learning.courses.index', compact('courses'));
    }

    public function search()
    {
        session()->remove('search[courses]');
        if (request('search'))
        {
            session()->put('search[courses]', request('search'));
            session()->save();
        }
        return redirect(route('courses.index'));
    }

    public function show(Course $course) {
        $course->load("units", "students", "reviews");
        return view('learning.courses.show', compact('course'));
    }
}
