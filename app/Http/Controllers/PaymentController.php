<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::with(['client'])->get();

        $data = [
            'payments'  =>  $payments
        ];

        return response()->json($payments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $payment = new Payment();
        $data = [
            'payment'   =>  $payment,
        ];
        return response()->json($data);
    }

    /**
     * Store a newly created resource in payment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'amount' => 'required',
            'date' => 'required',
            'payment_type_id' => 'required'
        ];
        $messages = [
            'amount.required' => 'El monto a pagar es obligatorio',
            'date.required' => 'La fecha de pago es obligatoria',
            'payment_type_id.required' => 'El tipo de pago es obligatorio'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return response()->json($validator->messages(),400);
        }

        if($request->has('id')) {
            $payment = Payment::find($request->id);
        } else {
            $payment = new Payment();
        }
        $payment->amount = $request->amount;
        $payment->date = $request->date;
        $payment->client_id = $request->client_id;
        $payment->payment_type_id = $request->payment_type_id;
        $payment->payment_code = $request->payment_code;
        $payment->receipt_type_id = $request->receipt_type_id;
        $payment->receipt_code = $request->receipt_code;
        $payment->contract_id = $request->contract_id;
        $payment->description = $request->description;
        if($request->hasFile('file')) {
            $payment->file = $request->file('file')->store('payments');
        }
        $payment->save();
        $construction_ids = \App\Construction::select('id')->where('client_id',$payment->client_id)->pluck('id')->toArray();
        $contracts = \App\Contract::whereIn('construction_id',$construction_ids)->get();
        $amount = $payment->amount;
        $rest = 0;
        foreach($contracts as $contract) {
            if($amount <= 0) {
                break;
            }
            if($amount > $contract->debt) {
                $amount = $amount - $contract->debt;
                $contract->debt = 0;
            } else {
                $contract->debt = $contract->debt - $amount;
                $amount = 0;
            }
            $contract->save();
        }
        $data = [
            'payment'    =>  $payment
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
        $payment = Payment::find($id); 
        $data = [
            'payment'  =>  $payment
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
        $payment = Payment::find($id);
        $data = [
            'payment'  =>  $payment
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
        $payment = Payment::find($id);
        $data = [
            'payment_id'    =>  $payment->id
        ];
        $payment->delete();
        return response()->json($data);
    }
}
