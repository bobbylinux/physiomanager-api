<?php

namespace App\Services\v1;


use App\Models\PaymentType;

class PaymentTypeService extends BaseService
{

    /**
     * Construct the class.
     *
     */
    public function __construct()
    {

        $this->clauseProperties = array(
            'id',
            'description',
            'enabled'
        );
        $this->rules = array(
            'description' => 'required'
        );
    }

    public function getPaymentType($parameters)
    {

        if (empty($parameters)) {
            $paymentType = $this->filterPaymentType(PaymentType::all());
        } else {
            $withKeys = $this->getWithKeys($parameters);
            $whereClauses = $this->getWhereClause($parameters);
            $paymentType = PaymentType::with($withKeys)->where($whereClauses)->orderBy('description')->get();
            $paymentType = $this->filterPaymentType($paymentType, $withKeys);
        }

        return $paymentType;

    }

    public function createPaymentType($request)
    {
        $this->validate($request->all());

        $paymentType = new PaymentType();
        $paymentType->description = $request->input("description");
        $paymentType->enabled = $request->input("enabled");

        $paymentType->save();

        return $this->filterPaymentType(array($paymentType));
    }

    public function updatePaymentType($request, $id)
    {
        $this->validate($request->all());

        $paymentType = PaymentType::findOrFail($id);
        $paymentType->description = $request->input("description");
        $paymentType->enabled = $request->input("enabled");

        $paymentType->save();

        return $this->filterPaymentType(array($paymentType));
    }

    public function deletePaymentType($id)
    {
        $paymentType = PaymentType::findOrFail($id);
        $paymentType->delete();
    }

    private function filterPaymentType($paymentTypes, $keys = array())
    {
        $data = array();

        foreach ($paymentTypes as $paymentType) {

            $item = array(
                'id' => $paymentType->id,
                'description' => $paymentType->description,
                'enabled' => $paymentType->enabled,
                'href' => route('payment_types.show', ['id' => $paymentType->id])
            );

            $data[] = $item;
        }

        return $data;
    }

}