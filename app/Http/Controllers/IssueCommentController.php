<?php

namespace App\Http\Controllers;

use App\IssueComment;
use App\Issue;
use Illuminate\Http\Request;
use App\Events\Issues\UpdatedIssue;
use App\Events\Issues\IssueCommentedFirstTime;
use App\Events\Issues\IssueClosed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IssueCommentController extends Controller
{
    public function store(Request $request)
    {
        $issuecomment = IssueComment::find($request->id);
        $issue = Issue::find($issuecomment->issue_id);
		if (!is_null($request->message))
		{
			IssueComment::find($issuecomment->id)->update([
				'checkin' => date('Y-m-d H:i:s',strtotime(now())),
                'comment' => $request->message,
                'contact_id' => $request->selected['id'],
                'type' => $request->type,
                'direction' => $request->direction,
			]);
			//Send mail to creator if another user and this is first comment
			if ($issue->userCreate_id <> $request->user_id)
			{
				if (IssueComment::where('issue_id', $issuecomment->issue_id)
				->count() == 1) 
				{
					event(new IssueCommentedFirstTime($issue));
				}
			}
			//Add commenter as follower if not already
			//Send mail to staff who is following
			if (!$request->follow) {
				$issue->followers()->attach($request->user_id);
			}
            event(new UpdatedIssue($issue, $type='comment',[]));
		}
        
        // TODO "fulhack".
        // istället för redirect, borde det vara
        // return response()->json($issuecomment, 200);
        // men då måste data hanteras med vuex, så sidan uppdateras med nya meddelanden
		$issuecomment->refresh();
        return redirect('/issues/'.$issuecomment->issue_id);		
    }
}
