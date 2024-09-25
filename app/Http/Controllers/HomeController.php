<?php

namespace App\Http\Controllers;

use App\Models\Product; 
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
        if(auth()->user()->isAdmin()){ // admin landing page
            return view('dashboard');

        } else { // user landing page
            return view('home');

        }

    }

    public function home() {
        $products = Product::all();  // Fetch products or data you need
        return view('home', ['products' => $products]);  // Pass products to the view
    }

}
