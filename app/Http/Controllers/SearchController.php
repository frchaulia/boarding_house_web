<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchBoarding(Request $request){
        if($request->search){
            $searchBoarding = BoardingController::where('name','LIKE','%'.$request->search,'%')->latest()->paginate(15);
            return view('frontend.index', compact ('searchBoarding'));
        }else{

        }
    }
}
