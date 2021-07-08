<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Login;
use App\Models\board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Success extends Controller
{
	public function index(Request $request, $id=""){
		$tests = Test::all();
		//글쓰기 로그인 페이지에서 email,name,password값 가져옴.
		$email = $request->input('email');
		$name = $request->input('name');
		$password = $request->input('password');
        //게시판 테이블에서 모든 정보 select해서 Success페이지에서 보여주게 하기 위해서
		$boards = board::all();

		$credentials = $request->only('email','name','password');
		if (Auth::attempt($credentials)) {
            return redirect('/success');
        }

		return view('Success',['tests'=>$tests,'boards'=>$boards]);
	}

	//로그 아웃 할때 사용
	public function logout() {
	    Auth::logout();

	    return redirect()->route('main');
    }
	//글 쓰는 곳임. Auth로 사용자 정보 없으면 다시 홈으로 가겠금 설정 했음.
	public function write($id=0){
        $tests = Test::all();
        $boards = board::all();
        if(!isset($boards)) $boards= [];
        return view('write',['tests'=>$tests,'boards'=>$boards]);
	}

	//id,title,name,content값을 받아온다.
	public function writecontroller(Request $request, $id=""){
		$save_board = board::find($id);
		if(!isset($save_board))$save_board= new board();
		//save_board변수에 title,name,content,save값 넣습니다.
		$save_board->title = $request->input("title","");
		$save_board->name = $request->input("name","");
		$save_board->content = $request->input("content","");
		$save_board->save();

		if(Auth::check()){
			$tests = Test::all();
			$boards = board::all();
			return view('Success',['tests'=>$tests,'boards'=>$boards]);
		}else{
			return redirect('/');
		}
	}

	public function edit($id){
		$boards = board::find($id);
		$tests = Test::all();
		return view('write',['boards'=>$boards,'tests'=>$tests]);
	}
}
