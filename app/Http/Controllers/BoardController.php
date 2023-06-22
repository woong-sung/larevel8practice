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

    public function index()
    {
        $boards = $this->board->latest()->paginate(10);
        return view('boards.index', compact('boards'));
    }
    public function oldest(){
        $boards = $this->board->oldest()->paginate(10);
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
        $this->board['password'] = $request['password'];
        $this->board->save();

        return redirect()->route('boards.index');
    }

    public function detail_page(Board $board)
    {
        $comments = Comment::where('board_id', $board->id)->get();
        return view('boards.detail_page', compact('board', 'comments'));
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
        $comments = Comment::where('board_id', $board->id)->get();
        foreach ($comments as $comment) {
            $comment->delete();
        }
        $board->delete();
        return redirect()->route('boards.index');
    }

    public function search(Request $request)
    {
        $keyword = $request->query("keyword");
        $cnt = Board::select()->where('title', 'like', "%{$keyword}%")->count();
        $boards = Board::select()->where('title', 'like', "%{$keyword}%")->latest()->paginate(10);;

        return view('boards.search_list', compact('boards', 'keyword','cnt'));
    }

    public function verify_page(Board $board)
    {
        return view('boards.password_page', compact('board'));
    }
    public function verify(Board $board, Request $request)
    {
        $inputPassword = $request->password;
        if ($board->password == $inputPassword) {
            return redirect()->route("boards.detail_page", $board->id);
        } else {
            return redirect()->route("boards.verify_page", $board->id)->with('alert','비밀번호가 틀렸습니다.');
        }

    }
}
