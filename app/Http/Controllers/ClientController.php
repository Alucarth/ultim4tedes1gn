<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::orderBy('id')->get();

        $data = [
            'clients'  =>  $clients
        ];

        return response()->json($clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = new Client();
        $data = [
            'client'   =>  $client,
        ];
        return response()->json($data);
    }

    /**
     * Store a newly created resource in client.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('id')) {
            $client = Client::find($request->id);
        } else {
            $client = new Client();
            $client->total = 0;
            $client->paid = 0;
            $client->debt = 0;
        }
        $client->name = $request->name;
        $client->nit = $request->nit;
        $client->legal_representative = $request->legal_representative;
        $client->address = $request->address;
        $client->phone = $request->phone;
        $client->description = $request->description;
        $client->save();

        $data = [
            'client'    =>  $client
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
        $client = Client::find($id);
        $data = [
            'client'  =>  $client
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
        $client = Client::find($id);
        $data = [
            'client'  =>  $client
        ];
        return response()->json($data);
    }

    /**
     * Update the specified resource in client.
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
        $client = Client::find($id);
        $data = [
            'client_id'    =>  $client->id
        ];
        $client->delete();
        return response()->json($data);
    }

    /**
     * Returns json data filtered from lumber
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
        $nit = $request->nit ?? '';
        $description = $request->description ?? '';

        $total = Client::
            where('name','like',$name.'%')
            ->where('nit', 'like', $nit.'%')
            ->where('description','like',$description.'%')
            ->count();

        $clients = Client::
            where('name','like',$name.'%')
            ->where('nit', 'like', $nit.'%')
            ->where('description','like',$description.'%')
            ->skip($offset)
            ->take($limit)
            ->orderBy($sort,$order)
            ->get();

        return response()->json([
            'clients' => $clients->toArray(),
            'total'=>$total,
        ]);
    }
}
