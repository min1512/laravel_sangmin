@extends('app')
@section('title','회원 리스트')
@section('scripts')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>
		$(function (){
			$('#make_menu').click(function (){
				var big_menu = $('#big_menu').val();
				var small_menu = $('#small_menu').val();

				$.ajax({
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					type: 'POST',
					url: '/list',
					data: {
						_token: '{{ csrf_token() }}',
						big_menu: big_menu,
						small_menu: small_menu
					},
					dataType: 'json',
					success : function (data){
						alert("성공");
					},
					error: function (data){
						alert(data);
					}
				});
			});
		})
	</script>
{{--<script>--}}
{{--	$(document).on('click', function(){--}}
{{--		$('#delete').html('정말 삭제 하시겠습니까?');--}}
{{--	});--}}
{{--</script>--}}
 @section('content')



	<div align="center" style="margin-top: 50px;">
		<table border="1">
			<tr>
				<th>
					인덱스
				</th>
				<th>
					이메일
				</th>
				<th>
					이름
				</th>
				<th>
					ABOUT
				</th>
			</tr>
			@foreach ($users as $user)
			@if(Auth::user()->id == $user->id)
			<tr>
				<td>
					{{ $user->id}}
				</td>
				<td>
					{{$user->email}}
				</td>
				<td>
					{{$user->name}}
				</td>
				<td>
					<a href="login/{{ $user->id}}">수정</a>
					<a href="delete/{{ $user->id}}" onclick="return confirm('정말 삭제 하시겠습니까?');">삭제</a>
				</td>
			</tr>
			@endif
			@endforeach            
		</table>
	</div>

	<div align="center" style="margin-top: 100px;">

		<table border="1">
			<form name="menu">
				<tr>
					<td>대 메뉴</td>
					<td><input type="text" name="big_menu" id="big_menu"></td>
				</tr>
				<tr>
					<td>소 메뉴</td>
					<td><input type="text" name="small_menu" id="small_menu"></td>
				</tr>
				<input type="button" id="make_menu" value="생성">
			</form>
		</table>

	</div>

 @endsection
