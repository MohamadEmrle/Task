<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Content\storeRequest;
use App\Http\Traits\imageTrait;
use App\Models\Content;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ContentController extends Controller
{
    use imageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        return view('admin.pages.contents.index',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if($request->ajax()) {
            return datatables()->of(Content::whereHas('service')->get())
            ->addColumn('image', function($image) {
                $imagePath = '../storage/images/contents/' . $image->image;
                return $imagePath;
            })
            ->addColumn('serviceName', function($service) {
                return $service->service->name;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.pages.contents.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->saveImage($request->image,'storage/images/contents');
        Content::create($data);
        return redirect()->route('admin.content.create')->with(['store'=>'Store Content Successfully']);
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
        $contenteId = Content::find($id);
        $path = 'storage/images/contents/' . $contenteId->image;
        if(File::exists($path)) {
            File::delete($path);
        }
        $contenteId->delete();
        return response()->json([
            'success' => true,
            'message' => 'Content deleted successfully.'
        ]);
    }
}
