<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Mail\WelcomeMail;
use Mail;

class SendMail implements ShouldQueue
{
    use Queueable;

    public User $user;
    /**
     * Create a new job instance.
     */
    public function __construct(User $userV)
    {
        
        $this->user = $userV;
        echo $this->user;
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        Mail::mailer("smtp")->to($this->user->email)->send(new WelcomeMail($this->user)); 
        //
    }
}
