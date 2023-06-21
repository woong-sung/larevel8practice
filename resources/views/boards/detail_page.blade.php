@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-4 mb-3">Title: {{$board->title}}</h2>
        <a href="{{route("boards.index")}}">[...목록으로...]</a>
        <p style="text-align: right" class="pt-2">작성일: {{$board->created_at}}</p>

        <div class="content mt-4 rounded-3 border border-secondary">
            <div class="p-3">
                {{$board->content}}
            </div>
            <div class="p-3" style="text-align: right">
                작성자: {{$board->user_name}}
            </div>
        </div>
        @if(auth()->user()->id == $board->user_id)
            <div style="text-align: right; margin-top: 10px">
                <input type="button" class="btn btn-dark" value="수정"
                       onclick="location.href='{{route("boards.edit_page", $board)}}'"/>
                <form onsubmit="return confirm('정말로 삭제하겠습니까?')"
                      action="{{route('boards.destroy', $board->id)}}" method="post"
                      style="display:inline-block; height: 9px">
                    {{-- delete method와 csrf 처리필요 --}}
                    @method('delete')
                    @csrf
                    <input type="submit" class="btn btn-dark" value="삭제"/>
                </form>
            </div>
        @endif
        <form action="{{route('comments.store', $board)}}" method="post">
            @csrf
            <div class="mb-3 mt-2">
                <textarea rows="3" cols="40" name="content" class="form-control" id="name"
                          autocomplete="off"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">댓글 작성</button>
        </form>

        @foreach ($comments as $key => $comment)
            <div style="padding-bottom: 30px">
                <div class="content mt-4 rounded-3 border border-secondary">
                    <div class="p-3">
                        {{$comment->content}}
                    </div>
                    <div class="p-3" style="text-align: right">
                        작성자: {{$comment->user_name}}
                    </div>
                </div>
                <div style="float: right; margin-top: 8px">
                    @if($comment->user_id == @auth()->user()->id)
                        <form onsubmit="return confirm('정말로 삭제하겠습니까?')"
                              action="{{route('comments.destroy', $comment)}}" method="post"
                              style="display:inline-block; height: 9px;">
                            {{-- delete method와 csrf 처리필요 --}}
                            @method('delete')
                            @csrf
                            <input type="submit" class="btn btn-dark" value="삭제"/>
                        </form>
                    @else
                        <input type="button" class="btn btn-dark" value="삭제" onclick="alert('작성자가아닙니다')"/>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

@endsection
