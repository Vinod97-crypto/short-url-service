<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteMail extends Mailable
{
    use SerializesModels;

    public $invitation;

    public function __construct($invitation)
    {
        $this->invitation = $invitation;
    }

    public function build()
    {
        //return $this->view('emails.invite') 
                   // ->with(['invitation' => $this->invitation]);
					return $this->from('test@gmail.com', 'ShortUrl')  
                    ->view('emails.invite')
                    ->with(['invitation' => $this->invitation]);
    }
}