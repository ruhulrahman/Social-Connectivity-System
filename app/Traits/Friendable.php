<?php

namespace App\Traits;
use App\Friendships;

trait Friendable{
    public function test(){
        return "Hello Ruhul";
    }

    public function addFriendRequest($id){
        $Friendships = Friendships::create([
                'requester' => $this->id, // who is loged in
                'user_request' => $id,
        ]);

        if($Friendships){
            return back();
        }else{
            return 'Request Failed';
        }
    }



}