<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\storeContenteRequest;
use App\Http\Traits\imageTrait;
use App\Models\Content;
use App\Models\Service;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    use imageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        return view('site.pages.contact',compact('services'));
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
    public function store(storeContenteRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->saveImage($request->image,'storage/images/contents');
        Content::create($data);
        return redirect()->route('site.contact')->with(['store'=>'Store Content Successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
