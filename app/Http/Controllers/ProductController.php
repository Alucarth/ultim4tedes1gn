<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with(['product_type'])->get();

        $data = [
            'products'  =>  $products
        ];

        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Prouct();
        $data = [
            'product'   =>  $product,
        ];
        return response()->json($data);
    }

    /**
     * Store a newly created resource in product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('id')) {
            $product = Product::find($request->id);
        } else {
            $product = new Product();
        }
        $product->name = $request->name;
        $product->amount = $request->amount;
        $product->density = $request->density;
        $product->high = $request->high;
        $product->width = $request->width;
        $product->product_type_id = $request->product_type_id;
        $product->completed_type = $request->completed_type;
        $product->description = $request->description;
        $product->array_type = $request->array_type;
        $product->save();

        $data = [
            'product'    =>  $product
        ];
        return response()->json($data);
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
        $data = [
            'product'  =>  $product
        ];
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with(['product_type'])->find($id);
        $data = [
            'product'  =>  $product
        ];
        return response()->json($data);
    }

    /**
     * Update the specified resource in product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from client.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $data = [
            'product_id'    =>  $product->id
        ];
        $product->delete();
        return response()->json($data);
    }

    /**
     * Returns json data filtered from lumber
     *
     * @param int $id
     * @return \App\Prouct[] $products
     */
    public function getData(Request $request){

        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 10;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'asc';

        $name = $request->name ?? '';
        $completed_type = $request->completed_type ?? '';
        $description = $request->description ?? '';

        $total = Product::
            where('name','like',$name.'%')
            ->where('completed_type', 'like', $completed_type.'%')
            ->where('description','like',$description.'%')
            ->count();

        $products = Product::
            where('name','like',$name.'%')
            ->where('completed_type', 'like', $completed_type.'%')
            ->where('description','like',$description.'%')
            ->skip($offset)
            ->take($limit)
            ->orderBy($sort,$order)
            ->get();

        return response()->json([
            'products' => $products->toArray(),
            'total'=>$total,
        ]);
    }
}
