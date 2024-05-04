<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ImpersonateController extends Controller
{

    public function impersonate($id)
    {
        $user = User::findOrFail($id);

        if ($user->id == Auth::user()->id) {
            return back()->with('error', 'You cannot impersonate yourself.');
        }

        if ($user) {
            Auth::user()->impersonate($user);
            return redirect()->route('dashboard');
        }

        return redirect()->back();
    }

    public function stopImpersonate()
    {
        Auth::user()->leaveImpersonation();
        return redirect()->route('users.index');
    }

}
