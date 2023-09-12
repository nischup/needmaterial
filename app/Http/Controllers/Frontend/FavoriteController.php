<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        return view('frontend.my-favorites', [
            'favorites' => Favorite::with('auction')
                ->paginate($request->perPage)
        ]);
    }

    public function store($id)
    {
        $item = Favorite::where('auction_id', $id)
            ->where('user_id', auth()->user()->id)
            ->first();

        if ($item) {
            return redirect()->back()->withSuccess(['Listed in favorites!']);
        }

        Favorite::create([
            'user_id' => auth()->user()->id,
            'auction_id' => $id,
        ]);

        return redirect()->back()->withSuccess(['Listed in favorites!']);
    }

    public function destroy($id)
    {
        $item = Favorite::findOrFail($id);
        $item->delete();

        return redirect()->back()->withSuccess(['Deleted successfully!']);
    }
}
