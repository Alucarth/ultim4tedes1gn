<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Purchase;
use App\PurchaseLumber;
use App\Specie;
use App\LumberInventory;
use App\Lumber;
use App\Type;
use App\Unit;
use App\PackageLumber;
use App\Package;
use App\Provider;
use Log;
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
        $purchase = Purchase::with(['provider','lumbers','lumbers.specie','lumbers.type'])->find($id);

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
    public function importExcel(Request $request)
    {
        $path = $request->file('excel');
        global $rows;
        Excel::selectSheetsByIndex(0)->load($path, function($reader) {
            
            global $rows;
            $result = $reader->select(array('cefo','fecha','madera',  'tipo', 'unidad','espesor','ancho','largo','cantidad','cantidad_pie','precio_unitario'))->get();
            $rows =array();
            foreach($result as $row)
            {
                $specie = Specie::where('name','=',$row->madera)->first();
                $row['specie_id'] = $specie?$specie->id:0;
                $type = Type::where('name',$row->tipo)->first();
                $row['type_id'] = $type?$type->id:0;
                $unit = Unit::where('name',$row->unidad)->first();
                $row['unit_id'] = $unit?$unit->id:0;
   
                if($specie && $type && $unit)
                {
                    $row['valid'] = true;
                }else{
                    $row['valid']= false;
                }
                // Log::info($row);
                array_push($rows,$row);
            }

        });
        // Log::info(sizeof($rows));
        return response()->json($rows);
    }
    public function saveExcel(Request $request){
        
        $provider = Provider::find($request->provider_id);
        
        $purchase = null;
        foreach($request->purchases as $row)
        {
            $object = json_decode(json_encode($row)) ;
            Log::info(strtotime($object->fecha));
            Log::info(date('Y-m-d',strtotime($object->fecha)));
            if(!$purchase){

                $purchase = new Purchase;
                $purchase->date = date('Y-m-d',strtotime($object->fecha));
                $purchase->cefo = $object->cefo;
                $purchase->provider_id = $provider->id;
                $purchase->description = "importacion de compra via excel";
                $purchase->amount = $request->amount;
                $purchase->save();
            }


            if($object->valid)
            {
                $lumber = Lumber::where('type_id',$object->type_id)
                        ->where('specie_id',$object->specie_id)
                        ->where('unit_id',$object->unit_id)
                        ->where('high',$object->largo)
                        ->where('width',$object->ancho)
                        ->where('density',$object->espesor)
                        ->first();
                if(!$lumber){

                    $lumber = new Lumber;
                    $lumber->type_id= $object->type_id;
                    $lumber->specie_id= $object->specie_id;
                    $lumber->unit_id= $object->unit_id;
                    $lumber->high= $object->largo;
                    $lumber->width= $object->ancho;
                    $lumber->density= $object->espesor;
                    $lumber->save();
                }
                
                $purchase_lumber = new PurchaseLumber;
                $purchase_lumber->purchase_id = $purchase->id;
                $purchase_lumber->lumber_id = $lumber->id;
                $purchase_lumber->quantity = $object->cantidad;
                $purchase_lumber->save();
                
                
            }
        }
        return $request->all();
    }
}
