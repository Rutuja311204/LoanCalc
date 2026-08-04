<?php

namespace App\Controllers;

use App\Models\BankModel;
use App\Models\LoanTypeModel;

class Home extends BaseController
{
    public function index()
    {
        $loanTypeModel = new LoanTypeModel();
        $bankModel     = new BankModel();

        $data = [
            'title'     => 'LoanCalc - Smart Loan EMI Calculator & Application Portal',
            'loanTypes' => $loanTypeModel->getActive(),
            'banks'     => $bankModel->getActive(),
        ];

        return view('home/index', $data);
    }
}
