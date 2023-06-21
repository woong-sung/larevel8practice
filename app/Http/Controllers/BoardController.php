<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Board;

class BoardController extends Controller
{
    private $board;
    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    public function index(){
        $boards = $this->board->latest()->paginate(10);
        return view('boards.index', compact('boards'));
    }

    public function create_page()
    {
        return view('boards.create_page');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:64',
            'content' => 'required|max:256',
        ]);
        $this->board['user_id'] = auth()->user()->id;
        $this->board['user_name'] = auth()->user()->name;
        $this->board['title'] = $validated['title'];
        $this->board['content'] = $validated['content'];
        $this->board->save();

        return redirect()->route('boards.index');
    }

    public function detail_page(Board $board)
    {
        $comments = Comment::where('board_id', $board->id)->get();
        return view('boards.detail_page', compact('board','comments'));
    }

    public function edit_page(Board $board)
    {
        return view('boards.edit_page', compact('board'));
    }

    public function update(Request $request, Board $board)
    {
        $request = $request->validate([
            'title' => 'required|max:64',
            'content' => 'required|max:256',
        ]);
        $board->update($request);
        return redirect()->route('boards.index', $board);
    }

    public function destroy(Board $board)
    {
        $board->delete();
        return redirect()->route('boards.index');
    }
}
