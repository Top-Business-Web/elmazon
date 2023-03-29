<?php

namespace App\Http\Controllers\Api\Traits;

use App\Models\Notification;
use App\Models\PhoneToken;
use App\Models\User;

trait FirebaseNotification{

    private $serverKey = 'AAAAvcvsG5E:APA91bHXIApfxcgUYwNQohgWbydXAOTcjSr5dWzQpT5HnID-v0GN3HuxahdId2DG4saeoNHu7tSFdL3h9AOwH_p8HOst0IQNPKkbCMycBgI7ZkaB5XWpQdN3bmOAFItqdTNVMh8EJgKH';


    public function sendFirebaseNotification($data,$season_id){

        $url = 'https://fcm.googleapis.com/fcm/send';

        $usersIds = User::whereHas('season', function ($season) use($season_id){
            $season->where('season_id', '=',$season_id);
        })->pluck('id')->toArray();

        $tokens = PhoneToken::whereIn('user_id',$usersIds)->pluck('token')->toArray();

//        $image = $data['image'];
//
//        if($image != null){
//            $destinationPath = 'notifications/';
//            $file = date('YmdHis') . "." . $image->getClientOriginalExtension();
//            $image->move($destinationPath, $file);
//        }

        //start notification store
        Notification::create([
            'title' => $data['title'],
            'body' => $data['body'],
            'term_id' => $data['term_id'],
            'season_id' => $season_id,
//            'image' => $file ?? null,
        ]);

        $fields = array(
            'registration_ids' => $tokens,
            'data' => $data,
        );
        $fields = json_encode($fields);

        $headers = array(
            'Authorization: key=' . $this->serverKey,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }


    public function sendFirebaseNotificationTest($data,$season_id){

        $url = 'https://fcm.googleapis.com/fcm/send';

        $usersIds = User::whereHas('season', function ($season) use($season_id){
            $season->where('season_id', '=',$season_id);
        })->pluck('id')->toArray();

        $tokens = PhoneToken::whereIn('user_id',$usersIds)->pluck('token')->toArray();

//        $image = $data['image'];
//
//        if($image != null){
//            $destinationPath = 'notifications/';
//            $file = date('YmdHis') . "." . $image->getClientOriginalExtension();
//            $image->move($destinationPath, $file);
//        }

        //start notification store
        Notification::create([
            'title' => $data['title'],
            'body' => $data['body'],
            'term_id' => $data['term_id'],
            'season_id' => $season_id,
//            'image' => $file ?? null,
        ]);

        $fields = array(
            'registration_ids' => $tokens,
            'data' => $data,
        );
        $fields = json_encode($fields);

        $headers = array(
            'Authorization: key=' . $this->serverKey,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }



}