<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user_registrados = User::all()->count();
        $user_activos = User::where('active', 1)->get()->count();
        $user_inactivos = User::where('active', 0)->get()->count();

        return view('pages.home')->with([
            'user_registrados' => $user_registrados,
            'user_activos' => $user_activos,
            'user_inactivos' => $user_inactivos
        ]);
    }
}
