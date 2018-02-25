<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Auth;
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
    public function getPost(){
    	$posts = DB::table('posts')
		    	->leftJoin('users', 'posts.user_id', '=', 'users.id')
		    	->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
		    	->orderby('posts.id', 'desc')
		    	->get();
    	return $posts;
    }

    public function addPost(Request $request){
    	$content = $request->content;
    	$auid = Auth::user()->id;
    	$craete_post = DB::table('posts')->insert(
		    [
		    	'user_Id' => $auid, 
		    	'posts' => $content,
		    	'status' => 0,
		    	'created_at' => date('Y-m-d H:i:s'),
		    	'updated_at' => date('Y-m-d H:i:s'),
		    ]
		);
		if($craete_post){
			$posts = DB::table('posts')
		    	->leftJoin('users', 'posts.user_id', '=', 'users.id')
		    	->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
		    	->orderby('posts.id', 'desc')
		    	->get();
    		return $posts;
		}
    }
}
