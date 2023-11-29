<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Image\storeRequest;
use App\Http\Requests\Image\updateRequest;
use App\Http\Traits\imageTrait;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    use imageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.pages.images.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if($request->ajax()) {
            return datatables()->of(Image::whereHas('category')->get())
            ->addColumn('image', function($image) {
                $imagePath = '../storage/images/categories/' . $image->category->id . '/' . $image->image;
                return $imagePath;
            })
            ->addColumn('CategoryName', function($image) {
                return $image->category->name;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.pages.images.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->saveImage($request->image,'storage/images/categories/'.$request->category_id);
        Image::create($data);
        return redirect()->route('image.index')->with(['store'=>'Store Image Successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $record = Image::find($id);
        return response()->json($record);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateRequest $request, string $id)
    {
        $record = Image::whereHas('category')->where('id',$request->id)->first();
        $data = $request->user();
        if(request()->hasFile('image')) {
            File::delete('storage/images/categories/'.$record->category_id.'/'.$record->image);
        }
        if(isset($request->image)) {
            $data['image'] = $this->saveImage($request->image,'storage/images/categories/'.$request->category_id);
        }
        $record->update([
            'category_id'         => $request->category_id ?? $record->category_id,
            'image'               => $data['image'] ?? $record->image,
        ]);
        return redirect()->route('image.index')->with(['update'=>'Update Image Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $imageId = Image::find($id);
        $path = 'storage/images/categories/'.$imageId->category_id.'/'.$imageId->image;
        if(File::exists($path)) {
            File::delete($path);
        }
        $imageId->delete();
        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully.'
        ]);
    }
}
