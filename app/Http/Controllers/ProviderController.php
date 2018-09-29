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
        $order = request('order'??'');
        $pagination_rows = request('pagination_rows'??10);
        $name = request('name')??'';
        $first_name = request('first_name')??'';
        $last_name = request('last_name')??'';
        $position = request('position')??'';
        $email = request('email')??'';
        $phone = request('phone')??'';
        
        $conditions_provider = [];
        $conditions_contatcs = [];
        if($name != '')
        {
            array_push($conditions_provider,array('name','like',"%{$name}%"));
        }
        if($first_name != '')
        {
            array_push($conditions_contatcs,array('first_name','like',"%{$first_name}%"));
        }
        if($last_name != '')
        {
            array_push($conditions_contatcs,array('last_name','like',"%{$last_name}%"));
        }
        if($position != '')
        {
            array_push($conditions_contatcs,array('position','like',"%{$position}%"));
        }
        if($email != '')
        {
            array_push($conditions_contatcs,array('email','like',"%{$email}%"));
        }
        if($phone != '')
        {
            array_push($conditions_contatcs,array('phone','like',"%{$phone}%"));
        }

            // Log::info('buscando por '.$conditions_contatcs);
        $provider_list = Provider::with('contacts')
                                ->where($conditions_provider)
                                ->whereHas('contacts',function($query) use ($conditions_contatcs){
                                    $query->where($conditions_contatcs)->where('is_primary',true);
                                })
                                // ->orderBy('name',$order)
                                ->paginate($pagination_rows);
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
