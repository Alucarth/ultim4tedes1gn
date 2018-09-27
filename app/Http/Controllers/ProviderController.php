<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provider;
use App\Contact;
use Log;
class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $order = request('order');
        if(request('sorted')!="name")
        {
            //search in contacts
            $search = request('search');
            $sorted = request('sorted');
          
            Log::info('buscando por '.$search);
            $provider_list = Provider::with('contacts')
                                    ->whereHas('contacts',function($query) use ($sorted,$search){
                                        $query->where($sorted,'like',"%{$search}%")->where('is_primary',true);
                                    })
                                    ->orderBy('name',$order)
                                    ->paginate(10);
            return response()->json($provider_list->toArray());
        }
        $provider_list = Provider::query()
                        ->when(request('search'),function($query,$search){
                            $query->where(request('sorted'),'like',"%{$search}%");
                        })
                        ->with('contacts')
                        ->orderBy('name',$order)
                        ->paginate(10);
        return response()->json($provider_list->toArray());
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $provider = new Provider;
        $contact = new Contact;
        return response()->json(array('provider'=>$provider,'contact'=>$contact));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function getData(Request $request)
    {
        if($request->name== 'name')
        {
            return response()->json(Provider::where($request->name,'like',$request->value."%")->with('contacts')->get()->toArray()); 
        }else{
            return response()->json(Provider::with('contacts')->whereHas('contacts',function($q) use($request) { $q->where($request->name,'like',$request->value."%");})->get()->toArray()); 
        }

    }
}
