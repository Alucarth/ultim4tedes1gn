<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductType;
use Validator;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = ProductType::get();

        $data = [
            'types' => $types
        ];

        return response()->json($types);
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
        $rules = [
            'name' => 'required'
        ];
        $messages = [
            'name.required' => 'El campo nombre es requerido'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return response()->json($validator->messages(),400);
        }
        if($request->has('id')){
            $product_type = ProductType::find($request->id);
        }else{

            $product_type = new ProductType();
        }
        $product_type->name = $request->name;
        $product_type->description = $request->description;
        $product_type->save();

        return $product_type;
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
        //
        $product_type = ProductType::find($id);
        return response()->json($product_type);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product_type = ProductType::find($id);
        $data = [
            'product_type_id'    =>  $product_type->id
        ];
        $product_type->delete();
        return response()->json($data);
    }
}
