<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Auth\Events\Registered;
use App\Models\Feedback;
use App\Models\SecondFeedbacks;

class FeedbackController extends Controller
{
    public function contactus(): View
    {
        return view('contact');
    }

    public function showFeedbacks(Request $request)
    {
        $search = $request['search'] ?? '';
        if ($search != ''){
            $allfbs =  Feedback::whereHas('user', function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            })->sortable()->paginate(10);
        }
        else {
            $allfbs = Feedback::sortable()->paginate(10);
        }

        return view('pages.ql_admin.feedbacks', compact('allfbs', 'search'));
    }

    public function createFeedback(Request $request)
    {
        // dd($request->all());
        $user = auth()->user();
        if(!Auth::check()){
            return redirect()->back()->with('error', 'You must be logged first in to send feedback!');
        }

        $request->validate([
            'comment_content' => ['required'],
        ]);

        $feedback = SecondFeedbacks::create([
            'comment_content' => $request->comment_content,
            'user_id' => Auth::user()->id,
        ]);

        event(new Registered($feedback));

        return redirect()->route('contact')->with('success', 'Your feedback has been sent successfully!');

    }

    public function showFBtoAdmin()
    {
        $secondFeedbacks = SecondFeedbacks::all();

        foreach ($secondFeedbacks as $secondFbs) {
            $feedbacks = new Feedback;
            $feedbacks->comment_content = $secondFbs->comment_content;
            $feedbacks->user_id = $secondFbs->user_id;
            $feedbacks->datesend = $secondFbs->created_at;

            $feedbacks->save();
            $secondFbs->delete();
        }

        return redirect()->route('showFeedbacks');

    }

}
