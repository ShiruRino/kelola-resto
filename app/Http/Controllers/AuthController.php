<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login');;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    public function login(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return back()->withInput()->with('error', 'Incorrect username or password');
        }
        Auth::login($user);
        $request->session()->regenerate();
        $request>session('role', $user->role);
        History::create([
            'user_id' => $user->id,
            'action' => 'login',
            'table_name' => 'users',
            'record_id' => $user->id,
            'description' => 'User '.$user->username.' logged in',
        ]);
        return redirect()->route('index')->with('success', 'Login Berhasil');
    }
    public function logout(Request $request){
        History::create([
            'user_id' => Auth::user()->id,
            'action' => 'logout',
            'table_name' => 'users',
            'record_id' => Auth::user()->id,
            'description' => 'User '.Auth::user()->username.' logged out',
        ]);
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect()->route('login');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
