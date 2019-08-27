<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['contract','construction.client','products.product_type'])->get();

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
        $rules = [
            'name' => 'required',
            'contract_id' => 'required',
            'construction_id' => 'required',
            'start_date' => 'required',
            'status_id' => 'required',
            'products.*.quantity' => 'required',
            'products.*.high' => 'required',
            'products.*.width' => 'required',
            'products.*.density' => 'required'
        ];
        $messages = [
            'name.required' => 'El campo número de orden es obligatorio.',
            'contract_id.required' => 'El campo contrato es obligatorio.',
            'construction_id.required' => 'El orden campo es obligatorio.',
            'start_date.required' => 'El campo fecha de inicio es obligatorio.',
            'status_id.required' => 'El campo estado es obligatorio.',
            'products.*.quantity.required' => 'cantidad del producto es obligatorio para todos los ítems',
            'products.*.high.required' => 'El campo altura es obligatorio para todos los ítems',
            'products.*.width.required' => 'El campo ancho es obligatorio para todos los ítems',
            'products.*.density.required' => 'El campo espesor es obligatorio para todos los ítems',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return response()->json($validator->messages(),400);
        }

        if($request->has('id')) {
            $order = Order::find($request->id);
            $order->amount = $request->amount;
        } else {
            $order = new Order();
            $order->amount = 0;
        }
        $order->contract_id = $request->contract_id;
        $order->construction_id = $request->construction_id;
        $order->status_id = $request->status_id;
        $order->name = $request->name;
        $order->description = $request->description;
        $order->start_date = $request->start_date;
        $order->estimated_date = $request->estimated_date;
        if($request->hasFile('file') && $order->file != $request->file) {
            $order->file = $request->file('file')->store('orders');
        }
        $order->specie_id = $request->specie_id;
        $order->venesta = $request->venesta;
        $products = [];
        $quantity = 0;
        $order->save();
        foreach($request->products as $product) {
            $quantity += $product['quantity'];
            $products[$product['id']] = [
                'quantity' => $product['quantity'],
                'description' => $product['description'],
                'density' => $product['density'],
                'high' => $product['high'],
                'width' => $product['width'],
                'array_type' => $product['array_type']
            ];
            $order->products()->attach($products);
            $products = [];
        }
        $order->quantity = $quantity;
        $order->save();
        //$order->products()->syncWithoutDetaching($products);
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
        $order = Order::with(['contract','construction.client','products.product_type'])->find($id);
        $data = [
            'order'  =>  $order
        ];
        return response()->json($order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::with(['contract','construction.client','products.product_type'])->find($id);
        $data = [
            'order'  =>  $order
        ];
        return response()->json($order);
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
