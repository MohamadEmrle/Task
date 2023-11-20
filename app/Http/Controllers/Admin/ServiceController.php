<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\storeRequest;
use App\Http\Requests\Service\updateRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.services.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if($request->ajax()) {
            return datatables()->of(Service::select('*'))

            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.pages.services.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        $data = $request->validated();
        Service::create($data);
        return redirect()->route('admin.service.create')->with(['store'=>'Store Service Successfully']);
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
    public function edit($id)
    {
        $record = Service::find($id);
        return response()->json($record);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateRequest $request)
    {
        $record = Service::where('id',$request->id)->first();
        $record->update([
            'name'                  => $request->name ?? $record->name,
            'description'           => $request->description ?? $record->description,
        ]);
        return redirect()->route('admin.service.create')->with(['update'=>'Update Service Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoryId = Service::find($id);
        $categoryId->delete();
        return response()->json([
            'success' => true,
            'message' => 'Service deleted successfully.'
        ]);
    }
}
