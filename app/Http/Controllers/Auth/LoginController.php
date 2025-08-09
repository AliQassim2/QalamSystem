<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // your Blade login form
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string', // email, phone, or username
            'password' => 'nullable|string',
            'code'     => 'nullable|string',
        ]);

        // Find user by email, phone, or username
        $user = User::where('email', $request->login)
            ->orWhere('phone', $request->login)
            ->orWhere('username', $request->login)
            ->first();

        if (!$user) {
            return back()->withErrors(['login' => 'User not found']);
        }

        // Check login method
        if ($request->filled('password')) {
            // Password login
            if (!Hash::check($request->password, $user->password)) {
                return back()->withErrors(['password' => 'Invalid password']);
            }
        } elseif ($request->filled('code')) {
            // Code login
            if ($user->code_login !== $request->code) {
                return back()->withErrors(['code' => 'Invalid code']);
            }
        } else {
            return back()->withErrors(['login' => 'Password or code required']);
        }

        // Generate custom token + expiry
        $user->tokenremember = Str::random(60);
        $user->token_expires_at = Carbon::now()->addHour();
        $user->save();

        // Log the user into the web session
        Auth::login($user);
        $request->session()->regenerate(); // regenerate session ID to prevent fixation
        session(['code_login' => $user->code_login, 'tokenremember' => $user->tokenremember]);
        return view('welcome');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

    // Optional: regenerate code for code login
    public function generateLoginCode($id)
    {
        $user = User::findOrFail($id);
        $user->code_login = rand(100000, 999999); // 6-digit code
        $user->save();

        // Here you can send code via email/SMS
        return back()->with('success', 'New login code generated.');
    }
}
