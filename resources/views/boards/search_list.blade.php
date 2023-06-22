@extends('layouts.app')
{{--boards 레이아웃으로 --}}
{{--'content'부분에 적용--}}
@section('content')
    <div class="container">
        <h2 class="mt-4 mb-3">{{$cnt}} 건의 검색결과 : {{$keyword}}</h2>
        <a href="{{route("boards.index")}}">[...목록으로...]</a>
        <a href="{{route("boards.create_page")}}">
            <button type="button" class="btn btn-dark" style="float: right;">Create</button>
        </a>


        <table class="table table-striped table-hover">
            <colgroup>
                <col width="15%"/>
                <col width="40%"/>
                <col width="15%"/>
                <col width="15%"/>
                <col width="15%"/>
            </colgroup>
            <thead>
            <tr>
                <th scope="col">Number</th>
                <th scope="col">Title</th>
                <th scope="col">Writer</th>
                <th scope="col">Created At</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            {{-- blade 에서는 아래 방식으로 반복문을 처리 --}}
            {{-- Boards Controller의 index에서 넘긴 $boards(board 데이터 리스트)를 출력 --}}
            @foreach ($boards as $key => $board)
                <tr>
                    <th scope="row">{{$key+1 + (($boards->currentPage()-1) * 10)}}</th>
                    <td>
                        <a href="{{route("boards.detail_page", $board->id)}}">
                            {{$board->title}}
                        </a>
                    </td>
                    <td>
                        {{$board->user_name}}
                    </td>
                    <td>
                        {{$board->created_at}}
                    </td>
                    <td>
                        @if($board->user_id == @auth()->user()->id)
                            <input type="button" class="btn btn-outline-dark" value="수정"
                                   onclick="location.href='{{route("boards.edit_page", $board)}}'"/>
                            <form onsubmit="return confirm('정말로 삭제하겠습니까?')"
                                  action="{{route('boards.destroy', $board->id)}}" method="post"
                                  style="display:inline-block; height: 9px">
                                {{-- delete method와 csrf 처리필요 --}}
                                {{-- form은 get post 만 지원하기 때문에 다른 메서드는 지정해줘야함--}}
                                @method('delete')
                                @csrf
                                <input type="submit" class="btn btn-outline-dark" value="삭제"/>
                            </form>

                        @else
                            <input type="button" class="btn btn-outline-dark" value="수정" onclick="alert('작성자가아닙니다')"/>
                            <input type="button" class="btn btn-outline-dark" value="삭제" onclick="alert('작성자가아닙니다')"/>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- 라라벨 기본 지원 페이지네이션 --}}
        {!! $boards->withQueryString()->links() !!}
    </div>
    <div class="container">
        <form action="{{route('boards.search')}}" method="get">
            <label for="keyword" class="form-label">Search</label>
            <div class="mb-3">
                <input name="keyword" style="width: 200px; float: left; margin-right: 10px" class="form-control"
                       id="name">
                <button type="submit" class="btn btn-primary">검색</button>
            </div>
        </form>
    </div>
@endsection
