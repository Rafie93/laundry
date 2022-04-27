<?php

use App\Models\User;

function validationErrors($errors)
{
    $errorList = [];
    foreach ($errors->getMessages() as $attribute => $messages) {
        $errorList[] = [
            'attribute' => $attribute,
            'message'   => $messages[0],
        ];
    }

    return $errorList;
}

function generateOTP(){
    $otp = mt_rand(1000,9999);
    return $otp;
}
 
function statusOrder($status)
{
    if ($status==1) {
        return "Waiting Payment";
    }else if ($status==2) {
        return "Prepare Order";
    }else if ($status==3) {
        return "Delivery";
    }else if ($status==4) {
        return "Order Accepted";
    }else if ($status==5) {
        return "Canceled";
    }
    return "";
}

function nascondimiSendMessage($tujuan,$pesan)
{
    $apikey="b36b0460a07b324a3eb179ee30703006a39455da";
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://starsender.online/api/sendText?message='.rawurlencode($pesan).'&tujuan='.rawurlencode($tujuan.'@s.whatsapp.net'),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_HTTPHEADER => array(
        'apikey: '.$apikey
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    return json_encode($response); 
}
 
function sendFirebaseGlobal($title,$body)
{
    $firebaseToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();

    $SERVER_API_KEY = env('FIRE_SERVER_KEY');
  
    $data = [
        "registration_ids" => $firebaseToken,
        "notification" => [
            "title" => $title,
            "body" => $body,  
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

    return $response;
}

function sendFirebasePerUser($idUser,$title,$body)
{
    $firebaseToken = User::where('id',$idUser)
                    ->whereNotNull('fcm_token')
                    ->pluck('fcm_token')->all();

    $SERVER_API_KEY = env('FIRE_SERVER_KEY');
  
    $data = [
        "registration_ids" => $firebaseToken,
        "notification" => [
            "title" => $title,
            "body" => $body,  
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

    return $response;
}

function sendFirebaseToAdminStore($store_id,$title,$body)
{
    $firebaseToken = User::where('store_id',$store_id)
                            ->whereIn('role',[12,13,14])
                            ->whereNotNull('fcm_token')
                            ->pluck('fcm_token')->all();

    $SERVER_API_KEY = env('FIRE_SERVER_KEY');
  
    $data = [
        "registration_ids" => $firebaseToken,
        "notification" => [
            "title" => $title,
            "body" => $body,  
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

    return $response;
}


function integerToRoman($integer)
	{
		$integer = intval($integer);
		$result = '';
		
		// Create a lookup array that contains all of the Roman numerals.
		$lookup = ['M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1];
 
		foreach ($lookup as $roman => $value) {
			$matches = intval($integer/$value);
			$result .= str_repeat($roman, $matches);
			$integer = $integer % $value;
		}

		return $result;
	}
