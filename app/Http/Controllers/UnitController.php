<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UnitRepository;

class UnitController extends Controller
{
    public function __construct(UnitRepository $unitRepository)
    {
        $this->unit = $unitRepository;
    }

    public function index()
    {
        $units = $this->unit->getAllUnits();

        return view('units.index', compact('units'));
    }
    
    public function show(Unit $unit)
    {
        $unit = $this->unit->getUnitBySlug($unit->slug);

        $description = config("grammar_descriptions.{$unit->slug}", "この単元の説明はまだ登録されていません。");
    
        return view('units.show', compact('unit', 'description'));
    }    
}
