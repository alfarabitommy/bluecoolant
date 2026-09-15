<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MyTdsMail extends Mailable
{
    use Queueable, SerializesModels;

    // public $details;
    public $tdsRequest;
    public $attachmentPath;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tdsRequest, $attachmentPath)
    {
        // $this->details = $details;
        
        $this->tdsRequest = $tdsRequest;
        $this->attachmentPath = $attachmentPath;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->subject('TDS file bluecoolant')->view('frontend.pages.email.myTdsEmail');
        return $this->from('noreply@sefasgroup.com', 'bluecoolant.com')
                    ->subject('Here’s Your TDS Request from BlueCoolant.com')
                    ->view('frontend.pages.email.myTdsEmail')
                    ->attach($this->attachmentPath, [
                        'as' => 'TDS-Sample.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
