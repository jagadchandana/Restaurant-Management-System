<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * @return [type]
     */
    public function __invoke()
    {
        return Inertia::render('Dashboard');
    }
}
