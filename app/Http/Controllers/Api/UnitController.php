<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\Term;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // 1. نجلب كل الترمات المرتبطة بصف الطالب
        $terms = Term::where('grade_id', $user->grade_id)->pluck('id');
        
        // 2. نجلب الوحدات التي تقع ضمن هذه الترمات
        $units = Unit::whereIn('term_id', $terms)
                     ->with('lessons')
                     ->get();

        // 3. نرجع تقرير كامل للـ Debug
        return response()->json([
            'debug' => [
                'user_id' => $user->id,
                'user_grade_id' => $user->grade_id,
                'found_terms_ids' => $terms, // هل وجد السيرفر ترمات لهذا الصف؟
            ],
            'units' => $units
        ]);
    }
}