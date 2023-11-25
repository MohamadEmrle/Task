<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\categoryDataTable;
use App\DataTables\categoryDataTableEditor;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\storeRequest;
use App\Http\Requests\Category\updateRequest;
use App\Http\Traits\imageTrait;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    use imageTrait;
    public function categories()
    {
        $categories = Category::all();
        return view('admin.pages.categories.index',compact('categories'));
    }
    public function index(Request $request)
    {
        if($request->ajax()) {
            return datatables()->of(Category::select('*'))
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
    public function store(storeRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->saveImage($request->image,'storage/images/categories');
        Category::create($data);
        return redirect()->route('admin.category.index')->with(['store'=>'Store Category Successfully']);
    }
    public function edit($id)
    {
        $record = Category::find($id);
        return response()->json($record);
    }
    public function update(updateRequest $request)
    {
        $data = $request->user();
        $record = Category::where('id',$request->id)->first();
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
        return redirect()->route('admin.category.index')->with(['update'=>'Update Category Successfully']);
    }
    public function delete($id)
    {
        $categoryId = Category::find($id);
        $path = 'storage/images/categories/'.$categoryId->image;
        if(File::exists($path)) {
            File::delete($path);
        }
        $categoryId->delete();
        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.'
        ]);
    }
}
