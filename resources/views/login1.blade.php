@extends('app')
@section('title','로그인페이지')
@section('scripts')
<script>
function check(){
	var email = document.getElementById('email');
	var pwd = document.getElementById('password');
	if(email.value == ""){
		alert('아이디값 입력하세요');
		email.focus();
		return false;
	}else if(pwd.value == ""){
		alert('비밀번호값 입력하세요');
		pwd.focus();
		return false;
	}else{
		login.action='/success';
		login.submit();
		return true;
	}
}
</script>

@section('styles')

@section('content')
<form method="post" align="center" id="login">
	 {{ csrf_field() }}
	<table border="1" align="center" style="margin-top:250px">
		<tr><th>아이디</th><td><input type="text" id="email" name="email"></td></tr>
		<tr><th>비번</th><td><input type="password" id="password" name="password"></td></tr>		
	</table>
	<a onclick="check()">로그인</a>
	<a href="/login1">취소</a>
</form>
@endsection
