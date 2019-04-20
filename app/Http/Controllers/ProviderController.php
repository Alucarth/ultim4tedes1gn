<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provider;
use App\Contact;
use Illuminate\Support\Facades\Log;
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
        
        if($request->has('id')){
            $provider = Provider::find($request->id);
            // return $provider->contacts;
        }else{
            $provider = new Provider();
        }
        $provider->name = $request->name;
        // $provider->offer = $request->offer;
        $provider->description = $request->description;
        $provider->address1 = $request->address1;
        $provider->address2 = $request->address2;
        $provider->city = $request->city;
        $provider->balance = $request->balance;
        $provider->debit = $request->debit;
        $provider->save();

        $contacts = json_encode($request->contacts);
        $contacts = json_decode($contacts);
        
        $offer_types = json_encode($request->offer_types);
        $offer_types = json_decode($offer_types);
        $offer_ids = [];
        foreach($offer_types as $offer_type){
            array_push($offer_ids,$offer_type->id);
        }
        // return $offer_ids;
        $provider->offer_types()->sync($offer_ids);
        // return $offer_types;
        // return $contacts;
        $is_primary=true;
        $contact_news=[];
        //separando nuevos de actualizados
        // Log::info($contacts);
        foreach($contacts as $contact_update){
            // Log::info((object)$contact_object);
            // $contact_update= (object) $contact_object;
            // Log::info($contact_update->first_name);
            if(isset($contact_update->id)){
                $contact = Contact::find($contact_update->id);
                if($is_primary)
                {
                    $is_primary = false;
                }
                $contact->first_name = $contact_update->first_name;
                $contact->last_name = $contact_update->last_name;
                $contact->email = $contact_update->email;
                $contact->phone = $contact_update->phone;
                $contact->position = $contact_update->position;
                $contact->is_primary = $is_primary;
                $contact->save();
            }else{
               array_push($contact_news,$contact_update);
            }
        }
        // eliminarlos de la lita
        foreach($provider->contacts as $contact)
        {
            $find=false;
            foreach($contacts as $contacts_to_update){
               
                if(isset($contacts_to_update->id)){
                    if($contact->id == $contacts_to_update->id){
                        $find=true;
                        break;               
                    }
                }
            }
            if(!$find)
            {
                $contact->delete();
            }
        }
        //creando a nuevos contactos en caso de que hubiera
        foreach($contact_news as $contact){

            $new_contact = new Contact;
            $new_contact->provider_id = $provider->id;
            $new_contact->is_primary = $is_primary;
            $new_contact->first_name = $contact->first_name;
            $new_contact->last_name = $contact->last_name;
            $new_contact->email = $contact->email;
            $new_contact->phone = $contact->phone;
            $new_contact->position = $contact->position;
            $new_contact->save();
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
        $provider = Provider::with('contacts','offer_types')->where('id',$id)->first();
        // $contacts = Contact::where('provider_id',$provider->id)->get();
        $data = [
            'provider'  =>  $provider,
            // 'contacts' => $contacts
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
        $provider = Provider::with('contacts','offer_types')->where('id',$id)->first();
        $data = [
            'provider'  =>  $provider,
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
