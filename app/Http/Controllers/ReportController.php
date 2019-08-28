<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Lumber;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;
class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $species = DB::table('lumbers')
                    ->join('species','species.id','=','lumbers.specie_id')
                    ->select(DB::raw('count(*)  as qty, species.name'))
                    ->groupBy('lumbers.specie_id','species.name')
                    ->get();
        $data = [
            'species' => $species
        ];
        return response()->json($data);
    }

    public function test()
    {
        $username = 'Brian de Mena';
        $title = "Reporte ";
        $date =Carbon::now();

        // // $html = '<h1>Hello world</h1>';
        // return view('layouts.print', compact('username','date','title'));
         $view = \View::make('reports.test', compact('username','date','title'));
        $html_content = $view->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html_content);

        // (Optional) Setup the paper size and orientation
        // $dompdf->setPaper('A4', 'landscape');
        $dompdf->setPaper('letter');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('my.pdf',array('Attachment'=>0));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
}
