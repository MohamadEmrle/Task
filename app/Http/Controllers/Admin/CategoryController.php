<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\categoryDataTable;
use App\DataTables\categoryDataTableEditor;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\storeRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{

    public function categories()
    {
        return view('admin.pages.categories.index');
    }
    public function index(Request $request)
    {
        if($request->ajax()) {
            return datatables()->of(Category::select('*'))
            ->addColumn('action','admin.pages.categories.button')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.pages.categories.index');
    }
    public function store(storeRequest $request)
    {
        $data = $request->all();
        Category::create($data);
        return redirect()->route('admin.category.index')->with(['store'=>'Store Category Successfully']);
    }
}
