<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return back();
        dd(session('search[courses]'));
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
}
