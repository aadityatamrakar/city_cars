<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Transaction;
use App\User;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Yajra\Datatables\Datatables;

class DataLookupController extends Controller
{
    public function index()
    {
        return view('data_lookup.index');
    }

    public function customers()
    {
        if(! UsersController::check_access(1))
            return redirect()->route('access_denied')->with(['type'=>"error", 'info'=>"Access Denied!"]);
        return view('data_lookup.customer');
    }

    public function vehicles()
    {
        if(! UsersController::check_access(1))
            return redirect()->route('access_denied')->with(['type'=>"error", 'info'=>"Access Denied!"]);
        return view('data_lookup.vehicles');
    }

    public function transactions()
    {
        if(! UsersController::check_access(1))
            return redirect()->route('access_denied')->with(['type'=>"error", 'info'=>"Access Denied!"]);
        return view('data_lookup.transactions');
    }

    public function datatables_ajax_vehicles()
    {
        //$vehicles = Vehicle::first()->with('customer');
        $vehicles = DB::table('vehicles')->join('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->select([
                'vehicles.id as vid',
                'customers.id as cid',
                'customers.name', 'customers.mobile1', 'customers.city',
                'reg_no', 'chassis_no', 'engine_no', 'model',
                'variant', 'mfgyear', 'mi', 'insurance', 'finance', 'fuel',
                'warranty', 'warranty_exp', 'amc', 'amc_exp'])
            ->orderBy('vehicles.id', 'desc');

        return Datatables::of($vehicles)
            ->editColumn('warranty_exp', '{!! date(\'d/m/Y\', strtotime($warranty_exp)) !!}')
            ->editColumn('amc_exp', '{!! date(\'d/m/Y\', strtotime($amc_exp)) !!}')
            ->make(true);
    }

    public function datatables_ajax_customers()
    {
        $customers = Customer::query();
        return Datatables::of($customers)
            ->editColumn('dob', '{!! date(\'d/m/Y\', strtotime($dob)) !!}')
            ->make(true);
    }

    public function datatables_ajax_transactions()
    {
        //$transactions = Transaction::first()->with('customer')->with('vehicle');
        $transactions = DB::table('transactions')
            ->join('vehicles', 'vehicles.id', '=', 'transactions.vehicle_id')
            ->join('customers', 'customers.id', '=', 'transactions.customer_id')
            ->select([
                'transactions.id as tid',
                'vehicles.id as vid',
                'customers.id as cid',
                'customers.name', 'customers.mobile1', 'customers.city',
                'vehicles.reg_no', 'vehicles.model', 'vehicles.variant',
                'transactions.transaction_date', 'transactions.transaction_type',
                'transactions.amount', 'transactions.mobile', 'transactions.rating', 'transactions.remark'
            ])
            ->orderBy('transactions.id', 'desc');

        return Datatables::of($transactions)
            ->editColumn('transaction_date', '{!! date(\'d/m/Y\', strtotime($transaction_date)) !!}')
            ->make(true);
    }
}
