<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class ManagerController extends Controller
{
    public function dashboard()
    {
        return view('manager.dashboard');
    }
}
