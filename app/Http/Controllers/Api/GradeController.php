<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
    // بنرجع كل المراحل الدراسية عشان تظهر في الـ Dropdown
        return response()->json(\App\Models\Grade::all());
    }
}

