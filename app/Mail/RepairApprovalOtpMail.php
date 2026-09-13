<?php

namespace App\Mail;

use App\Models\Repair;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RepairApprovalOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Repair $repair)
    {
    }

    public function build()
    {
        return $this->subject('Confirm Your Repair — Al Huda Mobiles Repairing Lab')
            ->view('emails.repair-approval-otp');
    }
}