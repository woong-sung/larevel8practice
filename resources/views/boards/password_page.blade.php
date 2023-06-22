@extends('layouts.app')
{{--boards 레이아웃으로 --}}
{{--'content'부분에 적용--}}
@section('content')
    <div class="container">
        <h2 class="mt-4 mb-3">잠긴글: {{$board->title}}</h2>
        <div class="container">
            <form action="{{route("boards.verify",$board->id)}}" method="get">
                <label for="password" class="form-label">password</label>
                <div class="mb-3">
                    <input name="password" style="width: 200px; float: left; margin-right: 10px" class="form-control"
                           id="password" type="password">
                    @if($board)

                    @endif
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
@endsection
