<?php

namespace App\Controllers;

use App\Models\LoanTypeModel;

class EmiController extends BaseController
{
    public function index()
    {
        $loanTypeModel = new LoanTypeModel();

        $data = [
            'title'     => 'EMI Calculator - LoanCalc',
            'loanTypes' => $loanTypeModel->getActive(),
        ];

        return view('emi/calculator', $data);
    }
}
