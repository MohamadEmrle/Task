<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Identitie\storeRequest;
use App\Http\Requests\Identitie\updateRequest;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.about.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if($request->ajax()) {
            return datatables()->of(About::select('*'))
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.pages.about.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        $data = $request->validated();
        About::create($data);
        return redirect()->route('about.create')->with(['store'=>'Store About Successfully']);
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
        $record = About::find($id);
        return response()->json($record);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateRequest $request , string $id)
    {
        $record = About::where('id', $id)->first();
        if ($record) {
            $record->update([
                'description' => $request->description ?? $record->description,
            ]);
        }
        return redirect()->back()->with(['update' => 'Update About Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $about = About::findOrfail($id);
        $about->delete();
        return response()->json([
            'success' => true,
            'message' => 'About deleted successfully.'
        ]);
    }
}
