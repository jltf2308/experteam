<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\Questionary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\CloseCompaniesQuestionnaires;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //event(new CloseCompaniesQuestionnaires('Cuestionarios')); 
        return view('home');
    }
}