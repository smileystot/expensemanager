<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
class ExpenseController extends Controller
{
    public function insert(Request $request){
        $expense = new Expense;
        $expense->category_id = $request->get('category_id');
        $expense->amount = $request->get('amount');
        $expense->entry_date = $request->get('entry_date');
        $expense->save();
    }

    public function Update(Request $request){
        $expense = Expense::find($request->get('id'));
        $expense->category_id = $request->get('category_id');
        $expense->amount = $request->get('amount');
        $expense->entry_date = $request->get('entry_date');
        $expense->save();
    }

    public function Delete(Request $request){
        Expense::find($request->get('id'))->delete();
    }
}
