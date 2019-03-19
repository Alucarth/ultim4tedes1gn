<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provider;
use App\Contact;
use Log;
class ProviderController extends Controller
{
    
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = request('order')??'';
        $pagination_rows = request('pagination_rows')??10;
        $name = request('name')??'';
        $first_name = request('first_name')??'';
        $last_name = request('last_name')??'';
        // $position = request('position')??'';
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
        // if($position != '')
        // {
        //     array_push($conditions_contatcs,array('position','like',"%{$position}%"));
        // }
        if($email != '')
        {
            array_push($conditions_contatcs,array('email','like',"%{$email}%"));
        }
        if($phone != '')
        {
            array_push($conditions_contatcs,array('phone','like',"%{$phone}%"));
        }

            // Log::info('buscando por '.$conditions_contatcs);
        if(sizeof($conditions_contatcs)>0){
            $provider_list = Provider::with('contacts')
                                ->where($conditions_provider)
                                ->whereHas('contacts',function($query) use ($conditions_contatcs){
                                    $query->where($conditions_contatcs);
                                })
                                ->orderBy('name')
                                ->paginate($pagination_rows);    
        }else{
            
            $provider_list = Provider::with('contacts')
                                    ->where($conditions_provider)
                                    // ->whereHas('contacts',function($query) use ($conditions_contatcs){
                                    //     $query->where($conditions_contatcs);
                                    // })
                                    ->orderBy('name')
                                    ->paginate($pagination_rows);
        }   
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
        $provider = new Provider();
        $provider->name = $request->name;
        $provider->offer = $request->offer;
        $provider->description = $request->description;
        $provider->address1 = $request->address1;
        $provider->address2 = $request->address2;
        $provider->city = $request->city;
        $provider->balance = $request->balance;
        $provider->debit = $request->debit;
        $provider->save();
        $contacts = json_encode($request->contacts);
        $contacts = json_decode($contacts);
        
        $is_primary=true;

        foreach($contacts as $contact)
        {
            $new_contact = new Contact;
            $new_contact->provider_id = $provider->id;
            $new_contact->is_primary = $is_primary;
            $new_contact->first_name = $contact->first_name;
            $new_contact->last_name = $contact->last_name;
            $new_contact->email = $contact->email;
            $new_contact->phone = $contact->phone;
            $new_contact->position = $contact->position;
            $new_contact->save();
            if($is_primary)
            {
                $is_primary = false;
            }
        }
        return response()->json($provider);
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
        $provider = Provider::where('id',$id)->first();
        $contacts = Contact::where('provider_id',$provider->id)->get();
        $data = [
            'provider'  =>  $provider,
            'contacts' => $contacts
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
        $provider = Provider::where('id',$id)->first();
        $contacts = Contact::where('provider_id',$provider->id)->get();
        $data = [
            'provider'  =>  $provider,
            'contacts' => $contacts
        ];

        return response()->json($data);
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
        $provider = Provider::where('id',$id)->first();
        $provider->name = $request->name;
        $provider->offer = $request->offer;
        $provider->description = $request->description;
        $provider->address1 = $request->address1;
        $provider->address2 = $request->address2;
        $provider->city = $request->city;
        $provider->balance = $request->balance;
        $provider->debit = $request->debit;
        $provider->save();
        
        $contacts = json_encode($request->contacts);
        $contacts = json_decode($contacts);
        $ids = [];
        foreach($contacts as $contact)
        {
            if(isset($contact->id))
            {
                $new_contact = Contact::find($contact->id);
            }else{
                $new_contact = new Contact;
                $new_contact->provider_id = $provider->id;
                $new_contact->is_primary = false;
            }
            $new_contact->first_name = $contact->first_name;
            $new_contact->last_name = $contact->last_name;
            $new_contact->email = $contact->email;
            $new_contact->phone = $contact->phone;
            $new_contact->position = $contact->position;
            $new_contact->save();
            array_push($ids,$new_contact->id);
        }
        // //Todo: REvisar esta hueva
     
        // $delete_contancts = Contact::whereNotIn('id',$ids)->where('provider_id',$provider->id)->get();
   
        // foreach($delete_contancts as $contact)
        // {
        //     $contact->delete();
        // }

        $contacts = Contact::where('provider_id',$provider->id)->get();
        $data = [
            'provider'  =>  $provider,
            'contacts' => $contacts
        ];
        return response()->json($data);
        // $provider = Provider::find($id)->with('contacts')->first();
        
    }
    public function list()
    {
        return response()->json(Provider::select('id','name')->get());
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
        $provider = Provider::find($id);
        $data = [
            'provider_id'    =>  $provider->id
        ];
        $provider->delete();
        return response()->json($data);
    }

}
