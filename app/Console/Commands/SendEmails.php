<?php

namespace App\Console\Commands;

use App\Mailing;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send {mailing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send report mails to users.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $mailing = Mailing::find($this->argument('mailing'));
        $report = $this->get_data($mailing->report_id);
        dd($mailing->title, $report->title);
        $data = [
            'id'        => $report->id,
            'title'     => $report->title,
            'headers'   => $report->headers,
            'data'      => $report->data,
        ];

        $emails = [];
        foreach (json_decode($mailing->users) as $id){
            if(($user = User::find($id)) != null)
                array_push($emails, $user->email);
        }

        Mail::send('reports.make', $data, function($message) use ($emails){
            $message->to($emails)->subject('Report!');
        });

    }
}
