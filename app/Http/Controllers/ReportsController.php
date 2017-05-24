<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\Exception;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function view()
    {
        return view('reports.view');
    }

    public function make($id)
    {
        $report = $this->get_data($id);
        $data = [
            'id'        => $report->id,
            'title'     => $report->title,
            'headers'   => $report->headers,
            'data'      => $report->data,
        ];
        return view('reports.make')->with($data);
    }

    public function pivot($id)
    {
        return view('reports.pivot', compact('id'));
    }

    public function csv($id)
    {
        $report = $this->get_data($id);
        $this->make_excel($report, 'CityCars-'.$report->title)
            ->export('csv');
    }

    public function send_mail($id)
    {
        $report = $this->get_data($id);
        $filename = Date('U');
        $data = [
            'id'        => $report->id,
            'title'     => $report->title,
            'headers'   => $report->headers,
            'data'      => $report->data,
        ];

        //$emails = ['aaditya.span@gmail.com', 'aaditya@yopmail.com'];
        $emails = [Auth::user()->email];
        Mail::send('reports.make', $data, function($message) use ($emails, $filename){
            $message->to($emails)->subject('Report!');
        });

        return "Mail Sent!";
    }


    public function download($id)
    {
        $report = $this->get_data($id);
        $this->make_excel($report, 'CityCars-'.$report->title)
            ->download('xls');
    }

    public static function make_excel($report, $title)
    {
        return Excel::create($title, function($excel) use ($report) {
            $excel->sheet($report['title'], function($sheet) use ($report) {
                $header = $report['headers'];
                $data = array_map(function($o) use ($header) { return array_combine($header, ((array) $o)); }, $report['data']);
                $sheet->fromArray($data);
                $sheet->freezeFirstRow();
                $sheet->setAutoFilter();
                $sheet->setFontSize(14);
                $sheet->setAutoSize(true);
            });
        });
    }

    public static function get_data($id)
    {
        $report = Report::findOrFail($id);
        if($report->table == 'customers'){
            $report->sql_query = 'SELECT '.$report->columns.' FROM '.env('DB_TBL_PREFIX').'customers ' .
                'WHERE '.($report->query==''?'1':$report->query);
        }else if($report->table == 'vehicles'){
            $report->sql_query = 'SELECT '.$report->columns.' FROM '.env('DB_TBL_PREFIX').'vehicles ' .
                'JOIN '.env('DB_TBL_PREFIX').'customers ON '.env('DB_TBL_PREFIX').'customers.id='.env('DB_TBL_PREFIX').'vehicles.customer_id ' .
                'WHERE '.($report->query==''?'1':$report->query);
        }else if($report->table == 'transactions') {
            $report->sql_query = 'SELECT ' . $report->columns . ' FROM '.env('DB_TBL_PREFIX').'transactions ' .
                'JOIN '.env('DB_TBL_PREFIX').'customers ON '.env('DB_TBL_PREFIX').'customers.id='.env('DB_TBL_PREFIX').'transactions.customer_id ' .
                'JOIN '.env('DB_TBL_PREFIX').'vehicles ON '.env('DB_TBL_PREFIX').'vehicles.id='.env('DB_TBL_PREFIX').'transactions.vehicle_id ' .
                'WHERE ' . ($report->query==''?'1':$report->query);
        }else if($report->table == 'sessions') {
            $report->sql_query = 'SELECT ' . $report->columns . ' FROM '.env('DB_TBL_PREFIX').'sessions ' .
                'WHERE ' . ($report->query==''?'1':$report->query);
        }
        $report->params = json_decode($report->params);
        $report->headers = json_decode($report->headers);
        $data = DB::select($report->sql_query, $report->params);
        $report->data = $data;
        return $report;
    }

    public function raw_query(Request $request)
    {
        $query  = $request->sql_query;
        $params = $request->params?:[];

        $query .= " LIMIT 0, 10";
        try{
            return DB::select($query, $params);
        }catch(\Exception $error){
            return ['status'=>"error", "error"=>$error];
        }

    }

    public function save_report(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "type"      =>  "required",
            "title"     =>  "required",
            "table"     =>  "required",
            "query"     =>  "required",
            "headers"   =>  "required",
            "columns"   =>  "required",
            "params"    =>  "required",
        ]);

        if ($validator->fails()) {
            $data = ['status'=>"validation_failed"];
            $data['validator'] = $validator->errors();
            return $data;
        }else{
            $data = $request->only('type', 'title', 'table', 'query', 'headers', 'columns', 'params');
            $data['user_id'] = Auth::user()->id;
            if($request->has('report_id'))
                return ['status'=>"updated"];
            else{
                $report = Report::create($data);
                return ['status'=>"success", 'report'=>$report];
            }
        }
    }
}
