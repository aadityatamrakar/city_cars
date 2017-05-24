<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Transaction;
use App\User;
use App\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DataEntryController extends Controller
{
    public function dashboard()
    {
        return view('home');
    }

    public function data_entry()
    {
        if(! UsersController::check_access(2))
            return redirect()->route('access_denied')->with(['type'=>"error", 'info'=>"Access Denied!"]);

        return view('data_entry.index');
    }

    public function data_entry_edit($id)
    {
        if(! UsersController::check_access(2))
            return redirect()->route('access_denied')->with(['type'=>"error", 'info'=>"Access Denied!"]);

        $customer = Customer::findOrFail($id);
        return view('data_entry.index', compact('customer'));
    }

    public function post_data_entry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"      =>  "required",
            "mobile1"   =>  "required|numeric|digits:10",
            "mobile2"   =>  "nullable|numeric|digits:10|different:mobile1",
            "city"      =>  "required",
            "email"     =>  "nullable|email",
            "dob"       =>  "nullable|date_format:d/m/Y",
            "pincode"   =>  "nullable|numeric|digits:6",
        ]);

        if ($validator->fails()) {
            $data = ['status'=>"validation_failed"];
            $data['validator'] = $validator->errors();
            return $data;
        }else{
            $data = $request->only('name', 'mobile1', 'mobile2', 'city', 'pincode', 'address', 'email', 'autocard');
            $data['dob'] = isset($data['dob'])?Carbon::createFromFormat('d/m/Y', $request->dob)->format('Y-m-d'):null;
            $data['user_id'] = Auth::user()->id;
            if($request->has('customer_id')){
                $customer = Customer::find($request->customer_id);
                $customer->update($data);
                return ['status'=>"updated", 'customer_id'=>$customer->id];
            }else {
                $customer = Customer::create($data);
                return ['status' => "success", 'customer_id' => $customer->id];
            }
        }
    }

    public function post_vehicle_entry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "reg_no"        =>  "required",
            "chassis_no"    =>  "required|numeric",
            "engine_no"     =>  "required|numeric",
            "mfgyear"       =>  "required|numeric|digits:4",
            "warranty_exp"  =>  "nullable|date_format:d/m/Y",
            "amc_exp"       =>  "nullable|date_format:d/m/Y",
            "customer_id"   =>  "required|exists:customers,id",
        ]);

        if ($validator->fails()) {
            $data = ['status'=>"validation_failed"];
            $data['validator'] = $validator->errors();
            return $data;
        }else{
            $data = $request->only('reg_no', 'chassis_no', 'engine_no', 'model', 'variant', 'mfgyear', 'mi', 'insurance', 'warranty', 'amc', 'customer_id', 'finance', 'fuel');
            $data['insurance'] = isset($data['insurance'])?Carbon::createFromFormat('d/m/Y', $request->insurance)->format('Y-m-d'):null;
            $data['amc_exp'] = isset($data['amc_exp'])?Carbon::createFromFormat('d/m/Y', $request->amc_exp)->format('Y-m-d'):null;
            $data['warranty_exp'] = isset($data['warranty_exp'])?Carbon::createFromFormat('d/m/Y', $request->warranty_exp)->format('Y-m-d'):null;
            $data['user_id'] = Auth::user()->id;
            if($request->has('vehicle_id') && ($vehicle=Vehicle::find($request->vehicle_id))!=null && $vehicle->update($data))
                return ['status'=>"updated", "vehicle"=>$vehicle];
            else{
                $vehicle = Vehicle::create($data);
                return ['status'=>"success", 'vehicle_id'=>$vehicle->id, 'vehicle'=>$vehicle];
            }
        }
    }

    public function post_transaction_entry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "customer_id"       =>  "required|exists:customers,id",
            "vehicle_id"        =>  "required|numeric",
            "amount"            =>  "required|numeric",
            "mobile"            =>  "nullable|numeric|digits:10",
            "transaction_date"  =>  "nullable|date_format:d/m/Y",
            "transaction_type"  =>  "required",
        ]);

        if ($validator->fails()) {
            $data = ['status'=>"validation_failed"];
            $data['validator'] = $validator->errors();
            return $data;
        }else{
            $data = $request->only('customer_id', 'vehicle_id','transaction_type','amount','mobile','rating', 'remark');
            $data['transaction_date'] = isset($data['transaction_date'])?Carbon::createFromFormat('d/m/Y', $request->transaction_date)->format('Y-m-d'):null;
            $data['user_id'] = Auth::user()->id;
            if($request->has('transaction_id') && ($transaction=Transaction::find($request->transaction_id))!=null && $transaction->update($data) && $transaction->vehicle)
                return ['status'=>"updated", 'transaction'=>$transaction];
            else{
                $transaction = Transaction::create($data);
                $vehicle = $transaction->vehicle;
                return ['status'=>"success", 'transaction'=>$transaction];
            }
        }
    }

    public function duplicate(Request $request)
    {
        if($request->table == 'customers'){
            $customer = Customer::select('id', 'name')->where($request->column, $request->value)->first();
            if($customer != null) return ['status'=>"found", "customer"=>$customer];
            else return ['status'=>'not_found'];
        }else if($request->table == 'vehicles'){
            $vehicle = Vehicle::select('id', 'reg_no')->where($request->column, $request->value)->first();
            $customer = $vehicle->customer;
            if($vehicle != null) return ['status'=>"found", "vehicle"=>$vehicle, "customer"=>$customer];
            else return ['status'=>'not_found'];
        }
    }

    public function data_entry_merge($type, Request $request)
    {
        if($type == 'customer') {
            $validator = Validator::make($request->all(), [
                "cust_id" => "required|exists:customers,id",
                "merge_id" => "required|exists:customers,id",
            ]);

            if ($validator->fails()) {
                $data = ['status' => "validation_failed"];
                $data['validator'] = $validator->errors();
                return $data;
            } else {
                Vehicle::where('customer_id', $request->cust_id)->update(['customer_id'=>$request->merge_id]);
                Transaction::where('customer_id', $request->cust_id)->update(['customer_id'=>$request->merge_id]);
                Customer::find($request->cust_id)->delete();
                return ['status'=>'ok'];
            }
        }else if($type == 'vehicle') {
            $validator = Validator::make($request->all(), [
                "vehicle_id" => "required|exists:vehicles,id",
                "merge_id" => "required|exists:vehicles,id",
            ]);

            if ($validator->fails()) {
                $data = ['status' => "validation_failed"];
                $data['validator'] = $validator->errors();
                return $data;
            } else {
                $customer = Vehicle::find($request->merge_id)->customer;
                Transaction::where('vehicle_id', $request->vehicle_id)->update(['vehicle_id'=>$request->merge_id, 'customer_id'=>$customer->id]);
                Vehicle::find($request->vehicle_id)->delete();
                return ['status'=>'ok'];
            }
        }
    }

    public function get_vehicles(Request $request)
    {

        return Customer::find($request->customer_id)->vehicles;
    }

}
