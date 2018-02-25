<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use App\profile;
use App\Friendships;
use App\Notifications;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
       
        return view('profile.index')
                ->with('data', Auth::user()->profile); 
    }



    public function changePhoto(){
        return view('profile.photo'); 
    }

    public function editProfile(){
        return view('profile.editProfile')
                ->with('data', Auth::user()->profile); 
    }

    public function uploadPhoto(Request $request){
        $file = $request->file('pic');
        $filename = $file->getClientOriginalName();

        $path = 'img';
        $file->move($path, $filename);

        $userId = Auth::user()->id;

        DB::table('users')
            ->where('id', $userId)
            ->update(['pic' => $filename]);
        return back();

        //return view('profile.index');
    }

    public function updateProfile(Request $request){
        // $data = array();
        // $data['city'] = $request->city;
        // $data['country'] = $request->country;
        // $data['about'] = $request->about;


        $userId = Auth::user()->id;

        DB::table('profiles')
            ->where('user_id', $userId)
            ->update($request->except('_token'));

        return back();
    }


    public function findFriends(){
        $uaid = Auth::user()->id;

        $allusers = DB::table('users')
                    ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
                    ->where('users.id', '!=', $uaid)
                    ->get();

        //return view('profile.findFriends')->with('findingFnds', $allusers);  
        return view('profile.findFriends', compact('allusers')); 
    }

    public function friendDetails($id){
        $uaid = Auth::user()->id;
        $allusers = DB::table('users')
                    ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
                    ->where('users.id', '=', $id)
                    ->get(); 
        return view('profile.friendDetails', compact('allusers'));  
    }

    public function requests(){
        $uaid = Auth::user()->id;
        $fndRequest = DB::table('friendships')
                ->rightJoin('users', 'users.id', '=', 'friendships.requester')
                ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
                ->where('friendships.status', 0)
                ->where('friendships.user_request', '=', $uaid)
                ->get();
        
        return view('profile.requests', compact('fndRequest'));
    }

    public function accept($name, $id){
        $uaid = Auth::user()->id;
        $checkRequest = Friendships::where('requester', $id)
                        ->where('user_request', $uaid)
                        ->get()
                        ->first();
        if($checkRequest){
            $updateFriendship = DB::table('friendships')
                ->where('requester', $id)
                ->where('user_request', $uaid)
                ->update(['status' => 1]);

            // $addNotifiction = DB::table('notifications')
            //     ->where('user_logged', $uaid)
            //     ->where('user_hero', $id)
            //     ->update(['status' => 1]);

            $notf = new Notifications;
            $notf->user_hero = $id; //Whom fnd request accept
            $notf->user_logged = Auth::user()->id; //me
            $notf->status = '1'; //unread notifictions
            $notf->note = 'accepted your friend request';
            $notf->save();

            if($updateFriendship){
                return back()->with('msg', 'You are now friend with '.$name);
            }

        }else{
            echo "wrong";
        }
    }

    public function reject($requesterId){
        $uaid = Auth::user()->id;
        $rejectUserRequest = DB::table('friendships')
                                ->where('requester', $requesterId)
                                ->where('user_request', $uaid)
                                ->delete();
        return back()->with('msg', 'Request has been deleted');
    }

    public function unfriend($fndId){

        $uaid = Auth::user()->id;
        DB::table('friendships')
            ->where('requester', $uaid)
            ->where('user_request', $fndId)
            ->delete();
        return back()->with('msg', 'Unfriend has been successfully completed');
    }

    public function friendList(){
        $uaid = Auth::user()->id;
        
        $fnd1 = DB::table('friendships')        
                ->leftJoin('users', 'users.id', '=', 'friendships.requester')
                ->rightJoin('profiles', 'users.id', '=', 'profiles.user_id')
                ->where('status', 1)
                ->where('user_request', '=', $uaid)
                ->get();        
        $fnd2 = DB::table('friendships')
                ->leftJoin('users', 'users.id', '=', 'friendships.user_request')
                ->rightJoin('profiles', 'users.id', '=', 'profiles.user_id')
                ->where('status', 1)
                ->where('requester', '=', $uaid)
                ->get();


        // $friendList = DB::table('friendships')
        //         ->rightJoin('users', 'users.id', '=', 'friendships.requester')
        //         ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
        //         ->where('friendships.status', 1)
        //         ->where('friendships.user_request', '=', $uaid)
        //         ->get();

        $friends = array_merge($fnd1->toArray(), $fnd2->toArray());

        // $fndCount1 = DB::table('friendships')
        //         ->where('status', 1)
        //         ->where('requester', '=', $uaid)
        //         ->count();
        // $fndCount2 = DB::table('friendships')
        //         ->where('status', 1)
        //         ->where('user_request', '=', $uaid)
        //         ->count();

        // $fndCount = array_merge($fndCount1->toArray(), $fndCount2->toArray());

        // dd($fndCount);

        return view('profile.friendlists', compact('friends')); 
    }

    public function notifications($id){
        $uaid = Auth::user()->id;

        $notifications = DB::table('notifications')
                    ->leftJoin('users', 'users.id', 'notifications.user_logged')
                    ->rightJoin('profiles', 'profiles.user_id', 'users.id')
                    ->where('notifications.id', $id)
                    ->where('notifications.user_hero', Auth::user()->id)
                    ->orderBy('notifications.id','DESC')
                    ->get();
        
        DB::table('notifications')
                ->where('notifications.id', $id)
                ->update(['status' => 0]);

        return view('profile.notifications', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
