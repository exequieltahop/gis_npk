<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DataInputController extends Controller
{
    public function view_data_input() {
        try {
            return view('pages.data-input');
        } catch (\Throwable $th) {
            Log::error("Error : ".$th->getMessage());
            abort(500);
        }
    }

    // sign in
    public function sign_in(Request $request) {
        try {
            // validate
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'min:8']
            ]);

            // authenticate
            if(!Auth::attempt([
                'email' => $request->email,
                'password' => $request->password
            ])){
                Log::error("Error : 401");
                session()->flash('error' , 'Invalid Credential');
                return redirect()
                    ->back();
            }else{
                return redirect()->route('data-input'); // if success then return view data input
            }

        } catch (\Throwable $th) { // catch errors and exceptions
            Log::error("Error : ".$th->getMessage());
            session()->flash('error' , 'Unexpected Error! Pls Contact Developer');
            return redirect()
                ->back();
        }
    }

    // logout
    public function logout(Request $request) {
        try {
            Auth::logout(); // Logout the user

            // Invalidate session and regenerate CSRF token
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/');
        } catch (\Throwable $th) { // catch errors and exceptions
            Log::error("Error : ".$th->getMessage());
            abort(500);
        }
    }
}
