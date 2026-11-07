<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class WebController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('web.index', compact('departments'));
    }

    public function about()
    {
        return view('web.about');
    }
}
