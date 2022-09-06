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
        return view('list', [
            'title' => 'List',
            'route' => $request->route()->getName(),
            'feedbacks' => Feedback::paginate(5),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
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
        $feedback->answered_at = now();
        $feedback->save();

        return back()->with('status', 'Feedback status was changed to answered!');
    }

    public function downloadAttachment()
    {
        Storage::exists(
            'files/' . $folder . '/' . $attachment_name
        );

        return Storage::download($url);
    }
}
