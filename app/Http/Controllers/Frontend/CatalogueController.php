<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    public function show($id)
    {
        $catalogue = Catalogue::with('images')
            ->findOrFail($id);

        return response()->json(
            $catalogue
        );
    }
}
