<?php

namespace App\View\Components;

use App\Helpers\CookieHelper;
use Illuminate\View\Component;

class Navbar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $cookie = CookieHelper::logAccess();
        $navbar = [];
        if (isset($cookie->administrator)) {
            $administrator = $cookie->administrator;
            if ($administrator->level_id === 1) {
                $navbar = [
                    'Home' => '/',
                    'Users' => '/user',
                    'Mapping' => '/mapping',
                ];
            } elseif ($administrator->level_id === 2) {
                $navbar = [
                    'Home' => '/',
                    'Feedback' => '/feedback'
                ];
            }
        }
        return view('layouts.navbar', compact('navbar'));
    }
}
