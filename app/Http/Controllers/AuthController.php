<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()
                ->intended(route('dashboard'))
                ->with('success', 'Welcome back!');
        }

        return back()
            ->withErrors([
                'email' => 'The provided credentials do not match our records.'
            ])
            ->onlyInput('email');
    }

    public function register(Request $request)
    {
        // Validate registration fields
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:180|unique:users,email',
            'student_number' => 'nullable|string|max:60',
            'phone' => 'nullable|string|max:30',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
            ],
            'g-recaptcha-response' => 'required',
        ], [
            'g-recaptcha-response.required' =>
                'Please verify that you are not a robot.',
        ]);

        // Verify Google reCAPTCHA
        try {
            $response = Http::asForm()
                ->timeout(10)
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => config('services.recaptcha.secret_key'),
                    'response' => $request->input('g-recaptcha-response'),
                ]);

            if (
                !$response->successful() ||
                !$response->json('success')
            ) {
                return back()
                    ->withErrors([
                        'g-recaptcha-response' =>
                            'reCAPTCHA verification failed. Please try again.'
                    ])
                    ->withInput($request->except([
                        'password',
                        'password_confirmation'
                    ]));
            }

        } catch (\Exception $e) {
            return back()
                ->withErrors([
                    'g-recaptcha-response' =>
                        'Unable to verify reCAPTCHA. Please try again.'
                ])
                ->withInput($request->except([
                    'password',
                    'password_confirmation'
                ]));
        }

        // Remove reCAPTCHA response before saving
        unset($data['g-recaptcha-response']);

        // Assign student role
        $data['role'] = 'student';

        // Create student account
        $user = User::create($data);

        // Automatically log in the new student
        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Your student account has been created.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with('success', 'You have been logged out.');
    }
}