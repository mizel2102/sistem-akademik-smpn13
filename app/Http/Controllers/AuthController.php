<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $loginInput = $credentials['email'];

        $email = $loginInput;
        if (! filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
            // Check if teacher NIP (remove spaces that might be inside NIP)
            $cleanedInput = str_replace(' ', '', $loginInput);
            $teacher = \App\Models\Teacher::where('nip', $loginInput)
                ->orWhere('nip', $cleanedInput)
                ->first();

            if ($teacher && $teacher->user) {
                $email = $teacher->user->email;
            } else {
                // Check if student NISN (student_number) or NIS
                $student = \App\Models\Student::where('student_number', $loginInput)
                    ->orWhere('student_number', $cleanedInput)
                    ->orWhere('nis', $loginInput)
                    ->orWhere('nis', $cleanedInput)
                    ->first();
                if ($student && $student->user) {
                    $email = $student->user->email;
                }
            }
        }

        if (! Auth::attempt([
            'email' => $email,
            'password' => $credentials['password'],
        ], $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'These credentials do not match our records.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $route = match (true) {
            $request->user()->hasRole('admin') => 'dashboard',
            $request->user()->hasRole('guru-bk') => 'bk.dashboard',
            $request->user()->hasRole('teacher') => 'teacher.classes.index',
            $request->user()->hasRole('student') => 'student.records.index',
            default => 'dashboard',
        };

        return redirect()->intended(route($route));
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPassword(string $token): View
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) use ($request): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        $user->assignRole($studentRole);

        Auth::login($user);
        $request->session()->regenerate();

        // Auto-create a Student profile for newly registered users.
        // student_number: S{zero-padded user id}
        // grade_level: default to '7'
        try {
            Student::firstOrCreate([
                'user_id' => $user->id,
            ], [
                'student_number' => 'S' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                'grade_level' => '7',
            ]);
        } catch (\Throwable $e) {
            // Don't prevent login if student record creation fails; log for later.
            report($e);
        }

        return redirect(route('dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('home'));
    }
}
