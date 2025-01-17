<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    public function index()
    {
        // $user = Auth::user();
        $units = Unit::select('name', 'slug')->get();
        return view('units.index', compact('units'));
    }

    public function show(Unit $unit)
    {
        return view('units.show', compact('unit'));
    }

    // public function grammerChatGPT($slug)
    // {
    // $unit = Unit::where('slug', $slug)->firstOrFail();

    // return view('grammar_chatgpt.index', compact('unit'));
    // }

}
