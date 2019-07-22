<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::get();

        $data = [
            'orders'  =>  $orders
        ];

        return response()->json($orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $order = new Order();
        $data = [
            'order'   =>  $order,
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
        //return $request->all();
        if($request->has('id')) {
            $order = Order::find($request->id);
        } else {
            $order = new Order();
        }
        $order->contract_id = $request->contract_id;
        $order->constructtion_id = $request->construction_id;
        $order->name = $request->name;
        $order->quantity = $request->quantity;
        $order->descripcion = $request->description;
        $order->amount = 0;
        $products = [];
        foreach($request->products as $product) {
            array_push($products,$product['id']);
        }
        $order->products()->sync($products);
        $data = [
            'order'    =>  $order
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
        $order = Order::find($id);
        $data = [
            'order'  =>  $order
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
        $order = Order::find($id);
        $data = [
            'order'  =>  $order
        ];
        return response()->json($data);
    }

    /**
     * Update the specified resource in order.
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
        $order = Order::find($id);
        $data = [
            'order_id'    =>  $order->id
        ];
        $order->delete();
        return response()->json($data);
    }

    /**
     * Returns json data filtered from lumber
     *
     * @param int $id
     * @return \App\Prouct[] $orders
     */
    public function getData(Request $request){

        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 10;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'asc';

        $contract = $request->contract ?? '';
        $name = $request->name ?? '';
        $description = $request->description ?? '';
        $construction = $request->construction ?? '';

        $construction_conditions = [];
        $contract_conditions = [];
        $order_conditions = [];

        if($name) {
            array_push($construction_conditions, ['name','like',$name.'%']);
        }
        if($description) {
            array_push($construction_conditions, ['description', 'like', $description.'%']);
        }
        if($contract) {
            array_push($contract_conditions, ['name', 'like', $contract.'%']);
        }
        if($construction) {
            array_push($construction_conditions,['name','like',$construction.'%']);
        }
        $total = Order::with(['contract','construction'])
            ->where($order_conditions)
            ->whereHas('contract', function($query) use($contract_conditions) {
                $query->where($contract_conditions);
            })
            ->whereHas('', function($query) use($construction_conditions){
                $query->where($construction_conditions);
            })
            ->count();

        $order = Order::with(['contract','construction'])
            ->where($order_conditions)
            ->whereHas('contract', function($query) use($contract_conditions) {
                $query->where($contract_conditions);
            })
            ->whereHas('', function($query) use($construction_conditions){
                $query->where($construction_conditions);
            })
            ->get();

        return response()->json([
            'orders' => $order->toArray(),
            'total'=>$total,
        ]);
    }
}
