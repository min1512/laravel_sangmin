@extends('app')
@section('scripts')
    <script>
        function main_file_upload() {
            main_upload.action='/';
            main_upload.submit();
            return true;
        }
    </script>
@section('content')
    <form align="center" method="post" name="main_upload" id="main_upload" enctype="multipart/form-data">
        {{ csrf_field() }}
        <table align="center" border="1">
            <tr>
                <td><input type="file" name="main_file_upload" id="main_file_upload"></td>
            </tr>
            <tr>
                <td colspan="2"><img style="width: 990px; height: 300px;" src="/storage/main_upload/{{\Illuminate\Support\Facades\Auth::user()->id}}/{{$users->uploadfile}}"></td>
            </tr>
        </table>
    <a onclick="main_file_upload();">완료</a>
    </form>
@endsection
