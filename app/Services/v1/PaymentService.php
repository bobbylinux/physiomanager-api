<?php

namespace App\Services\v1;


use App\Models\Payment;

class PaymentService extends BaseService
{

    /**
     * Construct the class.
     *
     */
    public function __construct()
    {
        $this->supportedIncludes = array(
            'payment_type' => 'payment_type'
        );

        $this->clauseProperties = array(
            'id',
            'amount',
            'plan_id',
            'payment_type_id'
        );

        $this->rules = array(
            'amount' => 'required',
            'plan_id' => 'required',
            'payment_type_id' => 'required',
        );
    }

    public function getPayment($parameters)
    {

        if (empty($parameters)) {
            $payment = $this->filterPayment(Payment::orderBy('created_at')->all());
        } else {
            $withKeys = $this->getWithKeys($parameters);
            $whereClauses = $this->getWhereClause($parameters);
            $payment = Payment::with($withKeys)->where($whereClauses)->orderBy('created_at')->get();
            $payment = $this->filterPayment($payment, $withKeys);
        }

        return $payment;

    }

    public function createPayment($request)
    {
        $this->validate($request->all());

        $payment = new Payment();
        $payment->amount = $request->input("amount");
        $payment->payment_type_id = $request->input("payment_type_id");
        $payment->plan_id = $request->input("plan_id");
        $payment->note = $request->input("note");

        $payment->save();

        return $this->filterPayment(array($payment));
    }

    public function updatePayment($request, $id)
    {
        $this->validate($request->all());

        $payment = Payment::findOrFail($id);
        $payment->amount = $request->input("amount");
        $payment->payment_type_id = $request->input("payment_type_id");
        $payment->plan_id = $request->input("plan_id");
        $payment->note = $request->input("note");

        $payment->save();

        return $this->filterPayment(array($payment));
    }

    public function deletePayment($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
    }

    private function filterPayment($payments, $keys = array())
    {
        $data = array();

        foreach ($payments as $payment) {

            $item = array(
                'id' => $payment->id,
                'amount' => $payment->amount,
                'plan_id' => $payment->plan_id,
                'note' => $payment->note,
                'date' => $payment->created_at,
                'payment_type_id' => $payment->payment_type_id,
                'href' => route('payments.show', ['id' => $payment->id])
            );

            if (in_array('payment_type', $keys)) {
                if (isset($payment->payment_type)) {
                    $item['payment_type'] = array(
                        'id' => $payment->payment_type->id,
                        'description' => $payment->payment_type->description
                    );
                } else {
                    $item['payment_type'] = array();
                }
            }

            if (in_array('payment_type', $keys)) {
                if (isset($payment->payment_type)) {
                    $item['payment_type'] = array(
                        'id' => $payment->payment_type->id,
                        'description' => $payment->payment_type->description
                    );
                } else {
                    $item['payment_type'] = array();
                }
            }

            $data[] = $item;
        }

        return $data;
    }

}