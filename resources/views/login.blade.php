@extends('app')
@section('title', '회원가입 & 수정 페이지')
@section('scripts')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>
		$(function(){
			$('#button').click(function(){
				var id = '{{ isset($users->id)?$users->id:"" }}';
				var email = document.getElementById('email');
				var name = document.getElementById('name');
				var password = document.getElementById('password');
				var id_check = $('#id_check').text();
				var id_check_value = document.getElementById('id_check');
				console.log(id_check);

				if (email.value == "") {
					alert('아이디값을 입력하세요');
					email.focus();
					return false;
				}else if(name.value == ""){
			 		alert('이름을 입력하세요');
			 		name.focus();
			 		return false;
				} else if (password.value == "") {
					alert('비밀번호를 입력하세요');
					password.focus();
					return false;
				}else if(id_check !="사용가능합니다."){
					alert('중복 여부 확인하세요');
					return false;
				}else {
					id_table.action = '/login/' + id;
					id_table.submit();
					return true;
				}
			});
		});
	</script>
	<script>
		$(function(){
				$('#email').keyup(function(e){
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: 'POST',
                        url: '/login_test',
                        data: {
                            _token: '{{ csrf_token() }}',
                            email: $('#email').val()
                        },
                        dataType: 'json',
                        success: function (data) {
							var id = data.user;
                            if (data.code != 200) {
                            	$('#email_name').text(id);
                                $('#id_check').text('사용가능합니다.');
                            } else {
								$('#email_name').text(id);
                                $('#id_check').text("이메일은 이미 사용중인 아이디 입니다");								
                            }
                        },
                        error: function (data) {
                            alert(data);
                        }
                    });
			});
		});
	</script>

@section('content')
    <div align="center" style="margin-top:100px;">
        <form method="post" name="id_table" id="id_table" enctype="multipart/form-data">
            {{ csrf_field() }}
            <h2>{{isset($users->email)? '수정' : '회원가입'}} 페이지</h2>
            <table>
                <tr>
                    <th> 아이디 </th>
					<td> <input type="text" name="email" id="email" maxlength="10" value="{{ isset($users->email)?$users->email : "" }}"> </td>
					<!-- <td><input type="hidden" name="email_check" value="data"></td> -->
					<td><a id="execute">아이디를 입력하세요</a></td>
					<td><div id="email_name"></div></td>
					<td><div id="id_check"></div></td>
				</tr>
				<tr>
                    <th> 이름 </th>
					<td> <input type="text" name="name" id="name" maxlength="10" value="{{ isset($users->name)?$users->name : "" }}"> </td>
				</tr>
				<tr>
                    <th> 비번 </th>
                    <td> <input type="password" name="password" id="password" maxlength="20" value=""> </td>
                </tr>
				<!-- <tr>
				                    <th> 파일 </th>
				                    <td> <input type="file" name="uploadfile" id="uploadfile" value="{{ isset($users->uploadfile)?$users->uploadfile: "" }}"> </td>
				                </tr> -->
            </table>
            <div align="center">
                <a id="button">완료</a>
                <a id="reset">취소</a>
            </div>
        </form>
    </div>
@endsection
