<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
class RegisterController extends Controller
{
    public function showForm(): View { return view('auth.register'); }
    public function register(Request $request): RedirectResponse
    { $data=$request->validate(['name'=>['required','string','max:100'],'student_id'=>['nullable','string','max:20','unique:users,student_id'],'email'=>['required','email','max:255','unique:users,email'],'password'=>['required','confirmed','min:8','regex:/[A-Z]/','regex:/[0-9]/']]); $user=User::create(['name'=>$data['name'],'student_id'=>$data['student_id']??null,'email'=>$data['email'],'password'=>Hash::make($data['password']),'role'=>'student']); Auth::login($user); return redirect()->route('student.dashboard')->with('success','Student account created successfully.'); }
}
