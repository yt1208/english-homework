<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $units = Unit::select('name', 'slug')->get();
        return view('units.index', compact('units'));
    }
    
    public function show(Unit $unit)
    {
        $description = config("grammar_descriptions.{$unit->slug}", "この単元の説明はまだ登録されていません。");
    
        return view('units.show', compact('unit', 'description'));
    }
    
}
