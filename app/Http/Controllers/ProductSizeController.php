<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductSize;

class ProductSizeController extends Controller
{
    /**
     * Display a listing of the product sizes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes = ProductSize::all();
        return view('backend.product_size.index', compact('sizes'));
    }

    /**
     * Show the form for creating a new product size.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product_size.create');
    }

    /**
     * Store a newly created product size in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'size' => 'required|string|unique:product_sizes',
        ]);

        $size = ProductSize::create($validatedData);

        return redirect()->route('product_size.index')->with(
            $size ? 'success' : 'error', 
            $size ? 'Product size added successfully' : 'Error adding product size'
        );
    }

    /**
     * Show the form for editing the specified product size.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $size = ProductSize::findOrFail($id);
        return view('backend.product_size.edit', compact('size'));
    }

    /**
     * Update the specified product size in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $size = ProductSize::findOrFail($id);

        $validatedData = $request->validate([
            'size' => 'required|string|unique:product_sizes,size,' . $id,
        ]);

        $size->update($validatedData);

        return redirect()->route('product_size.index')->with(
            'success', 'Product size updated successfully'
        );
    }

    /**
     * Remove the specified product size from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $size = ProductSize::findOrFail($id);
        $size->delete();

        return redirect()->route('product_size.index')->with(
            'success', 'Product size deleted successfully'
        );
    }
}