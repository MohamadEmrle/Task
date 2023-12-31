<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\storeRequest;
use App\Http\Requests\Category\updateRequest;
use App\Http\Traits\imageTrait;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    use imageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.pages.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if($request->ajax()) {
            return datatables()->of(Category::all())
            ->addColumn('image', function($image) {
                $imagePath = '../storage/images/categories/' . $image->image;
                return $imagePath;
            })
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
        $data['image'] = $this->saveImage($request->image,'storage/images/categories');
        Category::create($data);
        return redirect()->route('Categories.index')->with(['store'=>'Store Category Successfully']);
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
        $record = Category::findOrfail($id);
        return response()->json($record);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateRequest $request, string $id)
    {
        $data = $request->validated();
        $record = Category::where('id',$id)->first();
        if(request()->hasFile('image')) {
            File::delete('storage/images/categories/'.$record->image);
        }
        if(isset($request->image)) {
            $data['image'] = $this->saveImage($request->image,'storage/images/categories');
        }
        $record->update([
            'name'            => $request->name ?? $record->name,
            'description'     => $request->description ?? $record->description,
            'image'           => $data['image'] ?? $record->image,
        ]);
        return redirect()->route('category.create')->with(['update'=>'Update Category Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $path = 'storage/images/categories/'.$category->image;
        if(File::exists($path)) {
            File::delete($path);
        }
        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.'
        ]);
    }
}
