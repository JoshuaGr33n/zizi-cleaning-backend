<?php

namespace App\Http\Controllers\Admin;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::firstOrCreate([], ['content' => 'Initial default content']);
        return $aboutUs;
    }

    // public function update(Request $request)
    // {
    //     // $aboutUs = AboutUs::firstOrFail();
    //     $aboutUs = AboutUs::firstOrCreate([]);
    //     $aboutUs->update(['content' => $request->content]);
    //     return $aboutUs;
    // }

    public function update(Request $request)
    {
        $aboutUs = AboutUs::firstOrCreate([]);
        $aboutUs->update([
            'content' => $request->input('content'),  // Use input() to retrieve the content data from FormData
        ]);
        return $aboutUs;
    }

    public function store(Request $request)
    {
        $path = $request->file('upload')->store('public/uploads');
        $url = asset(Storage::url($path));

        return response()->json([
            'uploaded' => true,
            'url' => $url,
        ]);
    }
}
