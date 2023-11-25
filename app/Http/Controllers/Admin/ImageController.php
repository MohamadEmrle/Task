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
    public function images()
    {
        $categories = Category::all();
        return view('admin.pages.images.index',compact('categories'));
    }
    public function index(Request $request)
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
    public function store(storeRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->saveImage($request->image,'storage/images/categories/'.$request->category_id);
        Image::create($data);
        return redirect()->route('admin.image.index')->with(['store'=>'Store Image Successfully']);
    }
    public function edit($id)
    {
        $record = Image::find($id);
        return response()->json($record);
    }
    public function update(updateRequest $request)
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
        return redirect()->route('admin.image.index')->with(['update'=>'Update Image Successfully']);
    }
    public function delete($id)
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
