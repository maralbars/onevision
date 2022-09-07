<?php

namespace App\Observers;

use App\Models\Feedback;
use Illuminate\Support\Facades\Mail;

class FeedbackObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the Feedback "created" event.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return void
     */
    public function created(Feedback $feedback)
    {
        $user = $feedback->user;
        Mail::send('emails.notify', ['user' => $user, 'feedback' => $feedback], function ($m) use ($user, $feedback) {
            $m->from($user->email, $user->name);
            $m->to('hello@exampleihh.com', config('app.name', 'Feedback CRM'))->subject('New feedback: ' . $feedback->subject);
        });
    }

    /**
     * Handle the Feedback "updated" event.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return void
     */
    public function updated(Feedback $feedback)
    {
        //
    }

    /**
     * Handle the Feedback "deleted" event.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return void
     */
    public function deleted(Feedback $feedback)
    {
        //
    }

    /**
     * Handle the Feedback "restored" event.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return void
     */
    public function restored(Feedback $feedback)
    {
        //
    }

    /**
     * Handle the Feedback "force deleted" event.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return void
     */
    public function forceDeleted(Feedback $feedback)
    {
        //
    }
}
