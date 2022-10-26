<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products =  Product::all();
        if($request->ajax()){
            return response()->json($products);
        }

        return view('product.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $request->validate([
             'name' => 'required',
             'price' => 'required',
          ]);

          $new_product = New Product();
          $new_product->name = $request->name;
          $new_product->description = $request->description;
          $new_product->price = $request->price;
          $new_product->save();

          return response([
            'success' => 'Product Added Successfully'
          ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = Product::findOrFail($id);
        return response()->json($edit,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        $request->validate([
            'name' => 'required|unique:products,name,'.$id
        ]);

        $product = Product::findOrfail($id);
        if(!$product){
            return response()->json(['msg'=>'Data not found'], 404);
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();

        return response()->json(['msg'=>'Product Update Successfully'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $product = Product::findOrFail($id);
         if(!$product){
            return response()->json(['msg'=>'Data not found'], 404);
        }

        $product->delete();
        return response()->json(['msg' => 'Product delete successfully!'], 200);
    }

    public function filterProduct(Request $request)
    {
         if($request->ajax()){
            // return $request->all();
            if(isset($request->sort) and $request->sort === 'low_to_high'){
                $low_to_high = Product::orderBy('price','ASC')->get();
                return response()->json($low_to_high);
            }else if(isset($request->sort) and $request->sort === 'high_to_low'){
                $high_to_low = Product::orderBy('price','DESC')->get();
                return response()->json($high_to_low);
            }else if(isset($request->sort) and $request->sort === 'asc'){
                $asc = Product::orderBy('name','asc')->get();
                return response()->json($asc);
            }else if(isset($request->sort) and $request->sort === 'desc'){
                $desc = Product::orderBy('name','desc')->get();
                return response()->json($desc);
            }
         }
    }
}

