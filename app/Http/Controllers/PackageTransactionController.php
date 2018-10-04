<?php

namespace App\Http\Controllers;

use App\PackageTransaction;
use App\Package;
use Illuminate\Http\Request;

class PackageTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $transfer = new PackageTransaction();

        $data = [
            'transfer'  => $transfer
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
        $number = $request->transfer['number'];
        $destination = $request->transfer['storage_destination_id'];
        foreach($request->packages as $package){
            $transfer = new PackageTransaction();
            $transfer->number = $number;
            $transfer->storage_destination_id = $destination;
            $transfer->date = date('Y-m-d');
            $transfer->description = "";
            $transfer->package_id = $package['id'];
            $transfer->storage_origin_id = $package['storage_id'];
            $transfer->save();            

            $package = Package::find($transfer->package_id);
            $package->storage_id = $destination;
            $package->save();
        }
        return 200;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PackageTransaction  $packageTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(PackageTransaction $packageTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PackageTransaction  $packageTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(PackageTransaction $packageTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PackageTransaction  $packageTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PackageTransaction $packageTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PackageTransaction  $packageTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(PackageTransaction $packageTransaction)
    {
        //
    }
}
