<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\EmployeeChart;

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
    // Method index untuk menampilkan halaman dengan chart
    public function index(EmployeeChart $chart)
    {
        $pageTitle = 'Home';
        return view('home', [
            'pageTitle' => $pageTitle,
            'chart' => $chart->build()
        ]);
    }
}
