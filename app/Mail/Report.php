<?php

namespace App\Mail;

use App\Http\Controllers\ReportsController;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Report extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $report, $filename;

    public function __construct($id)
    {
        $this->report = ReportsController::get_data($id);
        $this->filename = Date('U');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        ReportsController::make_excel($this->report, $this->filename)
            ->store('xls', storage_path('excel/exports'));

        return $this->view('welcome')
            ->attach(storage_path('excel/exports').$this->filename.'.xls', [
                    'as'    => "CityCars-Report.xls",
                    'mime'  => 'application/vnd.ms-excel'
                ]);
    }
}
