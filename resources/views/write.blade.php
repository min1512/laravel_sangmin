@extends('app')
@section('title','글쓰기 페이지 입니다')
@section('scripts')
    <script>
        function writing(){
			var id = "{{isset($boards->id)? $boards->id : ""}}";
            var title = document.getElementById('title');
            var name= document.getElementById('name');
            var content = CKEDITOR.instances.content.getData();
            if(title.value == ""){
                alert('제목을 입력해주세요');
                title.focus();
                return false;
            }else if(name.value == ""){
                alert('이름을 입력해주세요');
                name.focus();
                return false;
            }else if(content.value == ""){
                alert('내용을 입력해주세요');
                content.focus();
                return false;
            }else if(name.value != '{{Auth::user()->name}}'){
				alert('작성자가 다릅니다.');
				name.focus();
				return false;
			}else{
				board.action = '/write/' +id;
                board.submit();
                return true;
            }
        }
    </script>
    <script src='/script/ckeditor473/ckeditor.js'></script>
@append
@section('content')
<form method="post" align='center' name="board"  style="margin-bottom: 100px;" enctype="multipart/form-data">
	 {{ csrf_field() }}
	 <h2>{{isset($boards->id)? '글 수정 페이지' : '글 작성 페이지'}}</h2>
	<table align="center" style="margin-top: 50px;" >
		<tr>
			<th>제목</th><td><input type="text" name="title" id="title" value="{{isset($boards->title)? $boards->title : ""}}"></td>
		</tr>
		<tr>
			<th>글쓴이</th><td><input type="text" name="name" id="name" value="{{Auth::user()->name}}"></td>
		</tr>
		<tr>
            <th>내용</th>
                <td>
                    <textarea name="content" id="content"> {{isset($boards->content)?$boards->content:""}}</textarea>
                    <script>
                        CKEDITOR.replace( 'content',{
                        });
                    </script>
                </td>
		</tr>
		<tr>
			<th>사진</th><td><input type="file" name="board_upload_file" id="board_upload_file"></td>
		</tr>
		<tr>
			<td colspan="2">
                <img onclick="newOpen(this)" id="preview22" src="/storage/board_upload_file/{{isset($boards->id)? $boards->id: ""}}/{{isset($boards->board_upload_file)? $boards->board_upload_file : ""}}" />
            </td>
		</tr>
	</table>
    <div id="preview3" style="display:none; "><img src="" /></div>
	<div align="center">
		<a onclick="writing()">쓰기완료</a>
		<a href="/write">취소</a>
	</div>
</form>
<style>
    #preview22 { width:150px; height:150px;}
</style>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview22').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#board_upload_file").change(function(){
        readURL(this);
    });

    function newOpen(obj) {
        console.log($(obj).attr("src"));
        $("#preview3 img").attr("src",$(obj).attr("src"));
        $("#preview3").show();
    }
</script>
@endsection

