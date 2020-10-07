<?php

namespace App\Http\Controllers\Admin;

use App\ProductStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.productstatus.index')
            ->with('statuses', ProductStatus::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.productstatus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('reset')) {
            return redirect('admin/productstatus');
        }
        $validatedData = $request->validate([
            'description' => 'required',
        ]);
        $productStatus = ProductStatus::create($validatedData);
        return redirect('admin/productstatus')
            ->with('success', 'Ny status tillagd');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productStatus = ProductStatus::find($id);
        return view('admin.productstatus.edit', ['status' => $productStatus]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->has('delete')) {
            $entry = ProductStatus::find($id);
            $entry->delete();
            return redirect('admin/productstatus');
        }
        if ($request->has('reset')) {
            return redirect('admin/productstatus');
        }
        ProductStatus::whereId($id)
            ->update(['description' => $request->description]);
        return redirect('admin/productstatus');
    }
}
