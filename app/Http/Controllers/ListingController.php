<?php

namespace App\Http\Controllers;



use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function create()
    {
        
        $countries = Country::orderBy('name')->get();
        return view('pages.addlisting', compact('countries'));
    }

    public function getStates(Request $request)
    {
        return State::where('country_id', $request->country_id)
            ->orderBy('name')
            ->get();
    }

    public function getCities(Request $request)
    {
        return City::where('state_id', $request->state_id)
            ->orderBy('name')
            ->get();
    }
}
