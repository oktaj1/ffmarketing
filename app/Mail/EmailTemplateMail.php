<?php
// app/Mail/EmailTemplateMail.php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailTemplateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $template;

    public function __construct(EmailTemplate $template)
    {
        $this->template = $template;
    }

    public function build()
    {
        return $this->subject($this->template->name)
                    ->view('emails.email_template');
    }
}
