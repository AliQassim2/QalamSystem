<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interface\SendCodeInterface;
use App\Mail\LoginCodeMail;
use Illuminate\Support\Facades\Mail;

class SendCodeDirectRepository implements SendCodeInterface
{
    public function sendLoginCode(string $login): bool
    {

        // Find user by email, phone, or username
        $user = User::where('email', $login)
            ->orWhere('phone', $login)
            ->orWhere('username', $login)
            ->first();

        if (!$user) {
            return false;
        }

        $user->code_login = rand(100000, 999999);
        $user->save();

        // Directly sending email
        Mail::to($user->email)->send(new LoginCodeMail($user->code_login));

        return true;
    }
}
