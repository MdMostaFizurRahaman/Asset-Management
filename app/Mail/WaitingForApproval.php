<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WaitingForApproval extends Mailable
{
    use Queueable, SerializesModels;

    public $approval_id;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $assessment_approval_id)
    {
        $this->user = $user;
        $this->approval_id = $assessment_approval_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('An Assessment is waiting for your approval')->view('mails.waitingForApproval');
    }
}
