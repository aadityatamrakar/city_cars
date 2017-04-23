<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('send:email {mailing}', function (){

    $mailing = \App\Mailing::find($this->argument('mailing'));
    $report = \App\Http\Controllers\ReportsController::get_data($mailing->report_id);

    $data = [
        'id'        => $report->id,
        'title'     => $report->title,
        'headers'   => $report->headers,
        'data'      => $report->data,
    ];

    $emails = [];
    foreach (json_decode($mailing->users) as $id){
        if(($user = \App\User::find($id)) != null)
            array_push($emails, $user->email);
    }

    Mail::send('reports.make', $data, function($message) use ($emails){
        $message->to($emails)->subject('Report!');
    });

})->describe('Sending Emails to users');
