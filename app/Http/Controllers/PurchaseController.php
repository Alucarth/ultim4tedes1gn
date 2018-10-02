<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = $request->order ?? 'asc';
        $pagination_rows = $request->pagination_rows ?? 10;               

        $purchase_conditions = [];
        $provider_conditions = [];        
        

        $cefo = $request->cefo ?? null;        
        $date = $request->density ?? null;
        $amount = $request->description ?? null;        
        $provider = $request->provider ?? null;

        if ($cefo) {
            array_push($purchase_conditions, ['cefo','like',"%{$cefo}%"]);
        }
        if ($date) {
            array_push($purchase_conditions, ['date','like',"%{$date}%"]);
        }
        if ($amount) {
            array_push($purchase_conditions, ['amount', '=', "%{$amount}%"]);
        }
        if ($provider) {
            array_push($provider_conditions, ['name','like',"%{$provider}%"]);
        }        
        

        $purchases = Purchase::with(['provider'])
                            ->where($purchase_conditions)
                            ->whereHas('provider', function ($query) use ($provider_conditions) {
                                $query->where($provider_conditions);
                            })                            
                            ->paginate($pagination_rows);
        $data = [
            'purchases'   =>  $purchases
        ];
        return response()->json($purchases);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $purchase = new Purchase();
        $pivot = ['quantity'=>null];
        $data = [
            'purchase'  =>  $purchase,
            'pivot'    =>  $pivot,
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $purchase = new Purchase();
        $purchase->cefo = $request->purchase['cefo'];
        $purchase->date = $request->purchase['date'];
        $purchase->provider_id = $request->purchase['provider_id'];
        $purchase->description = $request->purchase['description'];
        $purchase->amount = $request->purchase['amount'];
        $purchase->save();
        $lumbers = [];
        foreach($request->lumbers as $lumber) {            
            $lumbers[$lumber['id']] = [
                'quantity' => $lumber['quantity']
            ];
        }                
        $purchase->lumbers()->attach($lumbers);        
        return $purchase;        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchase = Purchase::with(['provider'])->find($id);

        $data = [
            'purchase'  =>  $purchase
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
    }
}
