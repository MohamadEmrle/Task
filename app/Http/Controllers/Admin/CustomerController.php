<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\storeRequest;
use App\Http\Traits\imageTrait;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CustomerController extends Controller
{
    use imageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.customers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if($request->ajax()) {
            return datatables()->of(Customer::select('*'))
            ->addColumn('image', function($image) {
                $imagePath = '../storage/images/customers/'.$image->image;
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
        $data['image'] = $this->saveImage($request->image,'storage/images/customers');
        Customer::create($data);
        return redirect()->route('customer.create')->with(['store'=>'Store Customer Successfully']);
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
        $record = Customer::find($id);
        return response()->json($record);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = Customer::where('id',$request->id)->first();
        $data = $request->validated();
        if(request()->hasFile('image')) {
            File::delete('storage/images/customers/'.$record->image);
        }
        if(isset($request->image)) {
            $data['image'] = $this->saveImage($request->image,'storage/images/customers');
        }
        $record->update([
            'name'       => $request->name ?? $record->name,
            'email'      => $request->email ?? $record->email,
            'image'      => $data['image'] ?? $record->image,
        ]);
        return redirect()->route('admin.customer.create')->with(['update'=>'Update Customer Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id);
        $path = 'storage/images/customers/'.$customer->image;
        if(File::exists($path)) {
            File::delete($path);
        }
        $customer->delete();
        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully.'
        ]);
    }
}
