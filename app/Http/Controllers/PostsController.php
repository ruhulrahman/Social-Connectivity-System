<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PostsController extends Controller
{
    public function index(){
    	$posts = DB::table('posts')
		    	->leftJoin('users', 'posts.user_id', '=', 'users.id')
		    	->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
		    	->orderby('posts.id', 'desc')
		    	->get();

    	return view('welcome')->with('posts', $posts);
    }
}
