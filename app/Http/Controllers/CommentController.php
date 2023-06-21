<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\board;
use App\Models\Comment;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function store(Request $request, Board $board)
    {
        $request = $request->validate([
            'content' => 'required|max:256'
        ]);
        $this->comment['user_id'] = auth()->user()->id;
        $this->comment['user_name'] = auth()->user()->name;
        $this->comment['board_id'] = $board->id;
        $this->comment['content'] = $request['content'];
        $this->comment->save();

        return redirect()->route('boards.detail_page',$board->id);
    }

    public function destroy(Comment $comment)
    {
        $board_id = $comment->board_id;
        $comment->delete();
        return redirect()->route('boards.detail_page',$board_id);
    }
}
