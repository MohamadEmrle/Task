<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\storeRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;

class CategoryController extends Controller
{
    public function categories()
    {
        return view('admin.pages.categories.index');
    }
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = Category::all();
            return datatables()->of(Category::query()->get())
                ->addIndexColumn()
                ->addColumn('action',function($row) {
                    $actionBtn = '<a href="javascript::void(0)"class="edit btn btn-success btn-sm">Edit</a>
                                <a href="javascript::void(0)"class="btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])->make();
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
