<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Log;
use App\Specie;
use App\LumberInventory;
use App\Lumber;
use App\Type;
use App\Unit;
use App\PackageLumber;
use App\Storage;
class PackageController extends Controller
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

        $package_conditions = [];
        $storage_conditions = [];        
        

        $code = $request->code ?? null;        
        $name = $request->name ?? null;        
        $storage = $request->storage ?? null;

        if ($code) {
            array_push($package_conditions, ['code','like',"%{$code}%"]);
        }
        if ($name) {
            array_push($package_conditions, ['name','like',"%{$name}%"]);
        }        
        if ($storage) {
            array_push($storage_conditions, ['name','like',"%{$storage}%"]);
        }        
        

        $storages = Package::with(['storage'])
                            ->where($package_conditions)
                            ->whereHas('storage', function ($query) use ($storage_conditions) {
                                $query->where($storage_conditions);
                            })                            
                            ->paginate($pagination_rows);
        $data = [
            'storages'   =>  $storages
        ];
        return response()->json($storages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $package = new Package();
        $pivot = ['quantity'=>null];
        $data = [
            'package'  =>  $package,
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
        $package = new Package();
        $package->code = $request->package['code'];
        $package->name = $request->package['name'];
        $package->storage_id = $request->package['storage_id'];        
        $package->save();
        $lumbers = [];
        foreach($request->lumbers as $lumber) {            
            $lumbers[$lumber['id']] = [
                'quantity' => $lumber['quantity']
            ];
        }                
        $package->lumbers()->attach($lumbers);        
        return $package;        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {        
        
        $package = Package::with(['storage','lumbers','lumbers.specie','lumbers.type'])->find($package->id);
        
        $data = [
            'package' => $package
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        //
    }

    public function createTransfer(Request $request) {
        return 123;
    }
    public function importExcel(Request $request)
    {
        $path = $request->file('excel');
        global $rows;
        Excel::selectSheetsByIndex(0)->load($path, function($reader) {
            
            global $rows;
            $result = $reader->select(array('cefo','fecha','madera', 'codigo', 'tipo', 'unidad','espesor','ancho','largo','cantidad','cantidad_pie','precio_unitario'))->get();
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
        
        $store = Storage::find($request->storage_id);

        foreach($request->all() as $row)
        {
            $object = json_decode(json_encode($row)) ;
            // Log::info($object->unit_id );
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
                
                            

                $package =  Package::where('name',$object->cefo)
                                    ->where('code',$object->codigo)
                                    ->first();
                if(!$package){
                    $package = new Package;
                    $package->name = $object->cefo;
                    $package->code = $object->codigo;
                    $package->quantity = 0;
                    $package->storage_id = $store->id;
                    $package->save();
                }

                $package->quantity += $object->cantidad;
                $package->save();

                $package_lumber = PackageLumber::where('package_id',$package->id)->where('lumber_id')->first();
                if(!$package_lumber)
                {
                    $package_lumber = new PackageLumber;
                    $package_lumber->package_id = $package->id;
                    $package_lumber->lumber_id = $lumber->id;
                    $package_lumber->quantity = 0;
                    $package_lumber->save();
                }
                $package_lumber->quantity = $object->cantidad;
                $package_lumber->save();


                //Log::info($lumber);

                
            }
        }
        return $request->all();
    }
}
