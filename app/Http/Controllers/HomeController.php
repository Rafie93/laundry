<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{

    public function __construct()
    {
      //  $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function savePushNotificationToken(Request $request)
    {
        auth()->user()->update(['fcm_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }
    
    public function sendPushNotification(Request $request)
    {
        $firebaseToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();
          
        $SERVER_API_KEY = env('FIRE_SERVER_KEY');
  
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,  
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = ['Authorization: key=' . $SERVER_API_KEY,'Content-Type: application/json'];
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
  
        dd($response);
    }

    public function firebasetest()
    {
        $firebase = $this->initFirebase();
        $poshData = [
			"fullname" => "mila",
			"lastname" => "azzahra"
		];
		$postRef = $firebase->getReference('contacts')->push($poshData);
    }
}
