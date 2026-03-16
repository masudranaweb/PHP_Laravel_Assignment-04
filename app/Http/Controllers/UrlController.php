<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
    {
        return $request->user()->urls()->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'original_url'=>'required|url',
            'expires_at'=>'nullable|date'
        ]);

        do{
            $short = Str::random(6);
        }while(Url::where('short_code',$short)->exists());

        $url = Url::create([
            'user_id'=>$request->user()->id,
            'original_url'=>$data['original_url'],
            'short_code'=>$short,
            'expires_at'=>$data['expires_at']
        ]);

        return response()->json($url,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Url $url)
    {
        $this->authorize('view',$url);

        return $url;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Url $url)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Url $url)
    {
        $this->authorize('update',$url);

        $data = $request->validate([
            'original_url'=>'url',
            'expires_at'=>'date|nullable'
        ]);

        $url->update($data);

        return $url;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Url $url)
    {
        $this->authorize('delete',$url);

        $url->delete();

        return response()->noContent();
    }
}
