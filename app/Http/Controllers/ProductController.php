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
            else if(isset($request->sort) and $request->sort === 'active'){
                $active = Product::where('status',1)->get();
                return response()->json($active);
            }
            else if(isset($request->sort) and $request->sort === 'inactive'){
                $inactive = Product::where('status',0)->get();
                return response()->json($inactive);
            }
         }
    }

    public function Dataset()
    {
        // return "ok";
        $dataset = [
            ['name'=>'Book', 'description'=> 'Lorem ipsum dolor sit amet.', 'price'=>10.50],
            ['name'=>'Cat', 'description'=> 'Lorem ipsum dolor sit amet.', 'price'=>100.50],
            ['name'=>'Alpine', 'description'=> 'Lorem ipsum dolor sit amet.', 'price'=>50.50],
            ['name'=>'Speaker', 'description'=> 'Lorem ipsum dolor sit amet.', 'price'=>11.150],
            ['name'=>'keyboard', 'description'=> 'Lorem ipsum dolor sit amet.', 'price'=>220.50],
            ['name'=>'Mouse', 'description'=> 'Lorem ipsum dolor sit amet.', 'price'=>45.50],
            ['name'=>'Desktop', 'description'=> 'Lorem ipsum dolor sit amet.', 'price'=>225.50],
            ['name'=>'Marvel', 'description'=> 'Lorem ipsum dolor sit amet.', 'price'=>150.00],
            ['name'=>'Laptop', 'description'=> 'Lorem ipslum dolor sit amet.', 'price'=>500],
            ['name'=>'Mobile', 'description'=> 'Lorem ipsum dolor sit amet.', 'price'=>200.50],

        ];
        try {
            product::truncate();
            Product::insert($dataset);
            return "Product data Inserted";
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
}

