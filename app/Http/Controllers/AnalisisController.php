<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kanvasing;
use App\Models\Cakada;
use App\Models\TipeCakada;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class AnalisisController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:analisis read')->only('index');
    }

    public function index()
    {
        return view('mobile.frontend.analisis.index');
    }

}
