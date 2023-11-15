<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Image\storeRequest;
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
                $imagePath = '../dist/images/' . $image->category->id . '/' . $image->image;
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
        $data = $request->all();
        $data['image'] = $this->saveImage($request->image,'dist/images/'.$request->category_id);
        Image::create($data);
        return redirect()->route('admin.image.index')->with(['store'=>'Store Image Successfully']);
    }
    public function delete($id)
    {
        $imageId = Image::find($id);
        $path = 'dist/images/'.$imageId->category_id.'/'.$imageId->image;
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
