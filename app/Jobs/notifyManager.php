<?php

namespace App\Jobs;

use App\Models\Feedback;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class notifyManager implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public Feedback $feedback
    )
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->feedback->user;
        Mail::send('emails.notify', ['user' => $user, 'feedback' => $this->feedback], function ($m) use ($user) {
            $m->from($user->email, $user->name);
            $m->to('hello@exampleihh.com', config('app.name', 'Feedback CRM'))->subject('New feedback: ' . $this->feedback->subject);
        });
    }
}
