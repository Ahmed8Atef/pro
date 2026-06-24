<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        // إضافة regex للتأكد أن الهاتف أرقام فقط وبطول منطقي
        'phone' => 'required|string|regex:/^[0-9]{10}$/|unique:users,phone', 
        // التأكد أن الهوية أرقام فقط وبطول 10 خانات
        'identity' => 'required|string|digits:10|unique:users,identity', 
        'grade_id' => 'required|exists:grades,id',
        'password' => 'required|string|confirmed|min:6',
    ], [
        'phone.regex' => 'رقم الجوال يجب أن يتكون من 10 أرقام.',
        'identity.digits' => 'رقم الهوية يجب أن يكون 10 أرقام.',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'phone' => $validated['phone'],
        'identity' => $validated['identity'],
        'grade_id' => $validated['grade_id'],
        'password' => Hash::make($validated['password']),
        'role' => 'student',
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'تم إنشاء الحساب بنجاح', 
        'user' => $user,
        'access_token' => $token
    ], 201);
}

public function login(Request $request)
{
    $request->validate([
        'phone' => 'required|string', 
        'password' => 'required|string|min:6', // تأمين الحد الأدنى في الدخول أيضاً
    ]);

    $user = User::where('phone', $request->phone)
                ->orWhere('identity', $request->phone)
                ->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'بيانات الدخول غير صحيحة. يرجى التأكد من رقم الجوال/الهوية وكلمة المرور.'
        ], 401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'تم الدخول بنجاح',
        'access_token' => $token,
        'user' => $user
    ], 200);
}
public function logout(Request $request)
    {
        // حذف التوكن الحالي الذي استخدمه المستخدم للقيام بهذا الطلب
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'تم تسجيل الخروج بنجاح'
        ], 200);
    }
}