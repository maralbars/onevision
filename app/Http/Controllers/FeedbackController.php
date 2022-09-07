<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class FeedbackController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $feedbacks = Feedback::orderBy('answered_at', 'desc')->orderBy('id', 'desc');
        $title = 'All users feedbacks list';
        if (Gate::denies('see-full-feedback-list')) {
            $feedbacks->where('client_id', $request->user()->id);
            $title = 'My feedbacks list';
        }
        return view('list', [
            'title' => $title,
            'route' => $request->route()->getName(),
            'feedbacks' => $feedbacks->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (Gate::denies('see-leave-feedback')) {
            return redirect()->route('feedback.index')->withErrors(['Managers have no access to create feedbacks!']);
        }

        return view('create', [
            'title' => 'Leave feedback',
            'route' => $request->route()->getName(),
            'latestFeedback' => $request->user()->latestFeedback()->first(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFeedbackRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFeedbackRequest $request)
    {
        if (Gate::denies('see-leave-feedback')) {
            return redirect()->route('feedback.index')->withErrors(['Managers have no access to create feedbacks!']);
        }

        $name = '';
        $path = '';

        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $name = $attachment->getClientOriginalName();
            $path = $attachment->storeAs(
                'files/' . $request->user()->id . '/' . date('m-Y'),
                uniqid() . '.' . $attachment->getClientOriginalExtension()
            );
        }

        Feedback::create([
            'subject' => $request->validated('subject'),
            'description' => $request->validated('description'),
            'attachment_url' => $path,
            'attachment_original_name' => $name,
            'client_id' => $request->user()->id,
        ]);

        return redirect()->route('feedback.index')->with('status', 'Feedback saved successfully!');
    }

    /**
     * Update the status of feedback.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {
        if (Gate::denies('change-feedback-status')) {
            return back()->withErrors(['You have no access to edit feedback status!']);
        }

        $feedback->answered_at = now();
        $feedback->save();

        return back()->with('status', 'Feedback status was changed to answered!');
    }

    public function downloadAttachment(Feedback $feedback)
    {
        if (Gate::denies('download-attachments', $feedback)) {
            return back()->withErrors(['You have no access to download attachments!']);
        }

        Storage::exists($feedback->attachment_url);

        return Storage::download($feedback->attachment_url, $feedback->attachment_original_name);
    }
}
