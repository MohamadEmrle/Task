<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Identitie\storeRequest;
use App\Http\Requests\Identitie\updateRequest;
use App\Models\Identity;
use Illuminate\Http\Request;

class IdentityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.identities.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if($request->ajax()) {
            return datatables()->of(Identity::select('*'))
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.pages.categories.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        $data = $request->validated();
        Identity::create($data);
        return redirect()->route('admin.identitie.create')->with(['store'=>'Store Identitie Successfully']);
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
        $record = Identity::find($id);
        return response()->json($record);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateRequest $request)
    {
        $record = Identity::where('id',$request->id)->first();
        $record->update([
            'description'  => $request->description ?? $record->description,
        ]);
        return redirect()->route('admin.identitie.create')->with(['update'=>'Update Identitie Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoryId = Identity::find($id);
        $categoryId->delete();
        return response()->json([
            'success' => true,
            'message' => 'Identity deleted successfully.'
        ]);
    }
}
