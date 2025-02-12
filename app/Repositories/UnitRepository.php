<?php

namespace App\Repositories;

use App\Models\Unit;

class UnitRepository
{
    public function getAllUnits()
    {
        return $units = Unit::all();
    }

    public function getUnitBySlug($slug)
    {
        return Unit::where('slug', $slug)->firstOrFail();
    }
}