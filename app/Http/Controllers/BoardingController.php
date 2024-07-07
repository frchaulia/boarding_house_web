<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Boarding;
use Illuminate\Http\Request;

class BoardingController extends Controller
{
    public function index()
    {
        $properties = Boarding::with('category')->inRandomOrder()->get();

        return view('frontend.Boarding', compact('properties'));
    }

    public function show(Boarding $Boarding)
    {
        return view('frontend.detail', compact('Boarding'));
    }

}
