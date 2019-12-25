<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Product::get(),200);
    }

    public function getPost()
    {
        
       $product = User::with('post')->find(Auth::id());
        return response()->json($product,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;
        $product->user_id = Auth::id();
        $product->title = $request->input('title');
        $product->name = $request->input('name');
        $product->cost = $request->input('cost');
        $product->producer = $request->input('producer');
        $product->seats = $request->input('seats');
        $product->detail = $request->input('detail');
        if($request->hasFile('photo')){
            $fileName = $request->file('photo')->getClientOriginalName();
            $fileName = preg_replace('/\s+/', '', $fileName);
            $path = $request->file('photo')->move(public_path('upload/product'),$fileName);
            $photoURL = url('upload/product/'.$fileName); 
            $product->url_image = $photoURL;  
        }
        $product->save();
        return response()->json($product,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if(is_null($product))
        {
            return response()->json(['message' => 'Not Found!'],404);
        }
        return response()->json($product,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $product = Product::find($id);
        if(is_null($product))
        {
            return response()->json(['message' => 'Not Found!'],404);
        }
        $product->update($request->all());
        return response()->json($product,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if(is_null($product)||Auth::id()!=$product->user_id)
        {
            return response()->json(['message' => 'Not Found!'],404);
        }
        $product->delete();
        return response()->json(['message' => 'Successful'],204);
    }

    public function search(Request $request)
    {
        $product = Product::where('name','like','%'.$request->name.'%')->get();
        if(is_null($product))
        {
            return response()->json(['message' => 'Not Found!'],404);
        }
        return response()->json($product,200);
    }
}
