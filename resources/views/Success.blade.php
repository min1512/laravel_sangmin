@extends('app')
@section('title','반갑습니다^^')
@section('scripts')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@section('content')
@if(Auth::check())
<form method="get" action="{{ url()->current() }}">
    <table style="float: right; margin-top:50px; width: 400px; margin-right: 130px;" class="search_table" >
        <tr>
            <td>
                <select name="search" id="search">
                    <option value="1" {{ isset($search['search'])&&$search['search']=="1"?"selected":"" }}>제목</option>
                    <option value="2" {{ isset($search['search'])&&$search['search']=="2"?"selected":"" }}>작성자</option>
					<option value="3"{{isset($search['search'])&&$search['search']=='3'?"selected":""}}>제목+작성자</option>
                </select>
            </td>
            <td><input type="text" name="search_board" id="search_board" value="{{ isset($search['search_board'])&&$search['search_board']!=""?$search['search_board']:"" }}" /></td>
            <td><button type="submit">검색</button></td>
        </tr>
    </table>
</form>
<table align="center" style="margin-top: 100px;" class="w3-table-all">
	<tr class="w3-red">
		<th>No</th><th>제목</th><th>작성자</th><th>작성 시간</th><th>ABOUT</th>
	</tr>
	@foreach($boards as $k => $board)
	<tr>
		<td>{{$boards->total()-($boards->currentPage()-1)*$boards->perPage()-$k}}</td>
		<td>{{$board->title}}</td>
		<td>{{$board->name}}</td>
		<td>{{$board->updated_at}}</td>
		@if(Auth::user()->name == $board->name)
		<td><a href='/write/{{$board->id}}'>수정</a> &nbsp; <a onclick="return confirm('정말 삭제 하시겠습니까?');" href='/delete/{{$board->id}}'>삭제</a></td>
	</tr>
	@endif
	@endforeach
</table>
<div class="ul_test">
{{ $boards->appends($search)->links() }}
</div>
<div align="center">
	<a href="/write">글작성</a>
	<a onclick=reset();>취소</a>
</div>
@else
	로그인 이후 사용해 주세요.
@endif
@endsection
