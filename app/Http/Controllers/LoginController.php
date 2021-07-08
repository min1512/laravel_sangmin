<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Test;
use App\Models\Login;
use App\Models\Users;
use App\Models\Room;
use Illuminate\Support\Str;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\API as UserResource;

class LoginController extends Controller
{
	public function index(Request $request){
		//views/index.blade.php 파일을 반환
		$tests = Test::all();
		$users = Users::find(Auth::user()->id);
        if($request->hasFile('main_file_upload')) {
            $path = $request->file('main_file_upload')->store('main_upload/' . Auth::user()->id);
            $path2 = str_replace('main_upload/' . Auth::user()->id, "", "$path");
            $path3 = str_replace('/',"","$path2");
            $main_login = Users::find(Auth::user()->id);
            $main_login->uploadfile=$path3;
            $main_login->save();
        }
		return  view('index',['tests'=>$tests,'users'=>$users]);
	}

	public function list(){
		$tests = Test::all();
		$users = Users::all();
		//$path = Storage::get('public/images');
		//dd($path);
		return  view('list',['tests'=>$tests, 'users'=>$users]);
	}
	public function write($id=0){
		//로그인 및 수정모드로 수정상태로 처리
		$tests = Test::all();   //id값을 가져와서 수정 할때 사용.
		$users = Users::find($id);  //id값으로 검색을 해서 변수 logins에 넣었음 그런데 값이 존재 하지 않으면 logins를 []처리함.
		if(!isset($users)) $users = []; //login페이지에서 회원가입도 되고 수정도 가능하게끔 하고 싶음.
		return  view('login',['tests'=>$tests, 'users'=>$users]);
	}

	public function save(Request $request, $id="") {
		$save_login = Users::find($id);
		if(!isset($save_login)) $save_login = new Users();
		$save_login->email = $request->input("email","");
		$save_login->name = $request->input("name","");
		$save_login->password = bcrypt($request->input("password",""));
		$save_login->api_token = Str::random(12);
		$save_login->save();
		return redirect()->Route('main');
    }

	public function check(){
		$tests = Test::all();
	    if(Auth::check()) {
            return view('Success',['tests'=>$tests]);
        }
	    else {
            $tests = Test::all();
            return view('login1', ['tests' => $tests]);
        }
	}

	public function api(Request $request, $id=""){
	    return new UserResource(Users::find($id));
    }

    public function Naver_API(){
	    $tests = Test::all();
	    return view('Naver_api',['tests'=>$tests]);
    }

	public function login_test(Request $request){
        $data = [];
        $data['code'] = 200;
		$email = $request->input('email');
        $data['user'] = $request->input('email');
		$users = Users::where('email',$email)->first();

		if(!$users){
            $data['code'] = 201;
		}

        return response()->json($data);
	}

	public function date(){
	    $tests = test::all();
	    $rooms = Room::all();
	    //dd($rooms);
	    return view('date',['tests'=>$tests,'rooms'=>$rooms]);
    }

    public function date_check(Request $request){
	    $add_day=DB::table('rooms')->select('add_day')->where('biz_code','P201910002')->get();
	    $add_adult_price=DB::table('rooms')->select('per_adult_price')->where('biz_code','P201910002')->get();
        $add_children_price=DB::table('rooms')->select('children_price')->where('biz_code','P201910002')->get();
        $add_baby_price=DB::table('rooms')->select('baby_price')->where('biz_code','P201910002')->get();
        $default_room_price=DB::table('rooms')->select('default_price')->where('biz_code','P201910002')->get();

	    $data = [];
	    //DB에서 하루 추가 가격 가져 오기
        $data['DB_day'] = $add_day[0];
        //DB에서 성인 추가 가격
        $data['DB_adult'] = $add_adult_price[0];
        //DB에서 초딩 추가 가격
        $data['DB_children'] = $add_children_price[0];
        //DB에서 애기 추가 가격
        $data['DB_baby'] = $add_baby_price[0];
        //DB에서 디폴트 방 가격
        $data['DB_default'] = $default_room_price[0];

	    //몇박 추가 한지 확인
        $data['use_pension'] = $request->query('use_pension');
        //추가 성인
        $data['add_adult_value'] = $request->query('add_adult_value');
        //추가 어린이 몇명
        $data['add_children_value'] = $request->query('add_children_value');
        //추가 애기 몇명
        $data['add_baby_value'] = $request->query('add_baby_value');


	    return response()->json($data);
    }
}
