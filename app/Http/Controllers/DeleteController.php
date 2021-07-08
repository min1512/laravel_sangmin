<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Login;
use App\Models\Users;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function index($id=0){		
		$logins = Users::where('id',$id)->delete();		
		return redirect('/');		
	}
}
