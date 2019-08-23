<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contract;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contracts = Contract::with(['construction'])->get();

        $data = [
            'contracts'  =>  $contracts
        ];

        return response()->json($contracts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contract = new Contract();
        $data = [
            'contract'   =>  $contract,
        ];
        return response()->json($data);
    }

    /**
     * Store a newly created resource in contract.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('id')) {
            $contract = Contract::find($request->id);
        } else {
            $contract = new Contract();
        }
        $contract->name = $request->name;
        $contract->description = $request->description;
        $contract->contract_type_id = $request->contract_type_id;
        $contract->construction_id = $request->construction_id;
        $contract->employee_id = $request->employee_id;
        $contract->sales_commission = $request->sales_commission ?? 0;
        $contract->amount_commission = $request->amount_commission ?? 0;
        $contract->amount = $request->amount;
        $contract->debt = $request->amount;
        $contract->file = $request->file('file')->store('contracts');
        $contract->save();

        $data = [
            'contract'    =>  $contract
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
        $contract = Contract::find($id); 
        $data = [
            'contract'  =>  $contract
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
        $contract = Contract::find($id);
        $data = [
            'contract'  =>  $contract
        ];
        return response()->json($data);
    }

    /**
     * Update the specified resource in contract.
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
        $contract = Contract::find($id);
        $data = [
            'contract_id'    =>  $contract->id
        ];
        $contract->delete();
        return response()->json($data);
    }

    /**
     * Returns json data filtered from contract
     * 
     * @param int $id
     * @return \App\Client[] $clients
     */
    public function getData(Request $request){

        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 10;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'asc';

        $name = $request->name ?? '';
        $description = $request->description ?? '';
        $total = Contract::
             where('name','like',$name.'%')
             ->where('description','like',$name.'%')
            ->count();

        $contract = Contract::
        where('name','like',$name.'%')
            ->where('description','like',$name.'%')
            ->skip($offset)
            ->take($limit)
            ->orderBy($sort,$order)
            ->get();

        return response()->json([
            'contracts' => $contract->toArray(),
            'total'=>$total,
        ]);
    }
}
