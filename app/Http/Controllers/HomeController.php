<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $page_title = 'Home';
        $page_description = $this->description();
        return view('pages.home', compact('page_title', 'page_description'));
    }

    private function description()
    {
        return 'Bunker plate is an opensource laravel application';
    }
}
