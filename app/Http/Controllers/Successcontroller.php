<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Test;
use App\Models\Login;
use App\Models\board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class Successcontroller extends Controller
{
	public function index(Request $request){
		$tests = Test::all();
		$boards = board::all();

		$credentials = $request->only('email','name','password');
		if (Auth::attempt($credentials)) {
            return redirect('/success');
        }
		return view('Success',['tests'=>$tests,'boards'=>$boards]);
	}

	public function index2(Request $request){
        $tests = Test::all();
        $search['search'] = $request->query("search");
        $search['search_board'] = $request->query("search_board");
        $boards = board::orderby('id','desc');
		if(isset($search['search']) && $search['search']!="") {
		    if($search['search']=="1"){
                $search_field = "title";
                $boards = $boards->where($search_field,'like','%'.$search['search_board'].'%');
            }
		    else if($search['search']=="2"){
                $search_field = "name";
                $boards = $boards->where($search_field,'like','%'.$search['search_board'].'%');
            }
		    else if($search['search']=='3') {
		        $boards = $boards->where('title','like','%'.$search['search_board'].'%')->orwhere('name','like','%'.$search['search_board'].'%');
            }
        }
        $boards = $boards->paginate(5);
        //dd($boards);
		return view('Success',['tests'=>$tests,'boards'=>$boards, 'search'=>$search]);
	}

	//로그 아웃 할때 사용
	public function logout() {
	    Auth::logout();

	    return redirect()->route('main');
    }

	//글 쓰는 곳임
	public function write($id=0){
        $tests = Test::all();
        $boards = board::find($id);
        if(!isset($boards)) $boards= [];
        return view('write',['tests'=>$tests,'boards'=>$boards]);
	}

	//id,title,name,content값을 받아온다.
	public function save(Request $request, $id=""){
		$save_board = board::find($id);
		if(!isset($save_board))$save_board= new board();
		//save_board변수에 title,name,content,save값 넣습니다.
		$save_board->title = $request->input("title","");
		$save_board->name = $request->input("name","");
		$save_board->content = $request->input("content","");
		//$ext = $request->file('board_upload_file')->extension();
		//dd($ext);

        if($request->file('board_upload_file')){
            if($request->hasfile){
                $path = $request->file('board_upload_file')->store('board_upload_file/'.$request->id);
                return $path;
            }
            $path = $request->file('board_upload_file')->store('board_upload_file/'.$request->id);
            $path1 = str_replace("board_upload_file/".$request->id,"",$path);
            $path2 = str_replace("/","",$path1);
            $save_board->board_upload_file =$path2;
        }

		$save_board->save();

		if(Auth::check()){
			$tests = Test::all();
			$boards = board::all();
			//dd($boards);
            return redirect()->route('success',['tests'=>$tests,'boards'=>$boards]);
            //return redirect('/success',['tests'=>$tests,'boards'=>$boards]);
			//return view('Success',['tests'=>$tests,'boards'=>$boards]);

		}else{
			return redirect('/');
		}
	}
	public function search(Request $request){
	    $data = [];
	    $data1 = [];
	    $data['search_board'] = $request->input('search_board');
	    $data['search_title'] = $request->input('search_title');
	    $data['search_writer'] = $request->input('search_writer');
	    $data['board_title'] = DB::table('board')->select('id','title')->get();

        return response()->json($data);
    }

    public function delete($id=0){
	    $delete_boards = DB::table('board')->where('id',$id)->delete();
	    return redirect('/');
    }

    public function about(){
	    return view('about');
    }
}
