<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpaceController extends Controller
{
    /**
     * Redirect to products index with space filter
     */
    public function show($space)
    {
        $validSpaces = ['living_room', 'kitchen', 'bathroom', 'outdoor'];

        if (!in_array($space, $validSpaces)) {
            abort(404, 'Không gian không tồn tại');
        }

        return redirect()->route('products.index', ['space' => $space]);
    }
}
