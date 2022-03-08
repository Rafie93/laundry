<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Kreait\Firebase;  
use Kreait\Firebase\ServiceAccount;  
use Kreait\Firebase\Database;
use Kreait\Firebase\Factory;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	public function __construct(Database $database)
    {
        $this->database = $database;
    }
    protected function initPaymentGateway()
	{
		// Set your Merchant Server Key
		\Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
		// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
		\Midtrans\Config::$isProduction = false;
		// Set sanitization on (default)
		\Midtrans\Config::$isSanitized = true;
		// Set 3DS transaction for credit card to true
		\Midtrans\Config::$is3ds = true;
	}

	protected function initFirebase()
	{
		$factory = (new Factory)
		->withServiceAccount(__DIR__.'/Firebasekey.json')
		->withDatabaseUri('https://office-coffee-f4475-default-rtdb.asia-southeast1.firebasedatabase.app');
	
		$auth = $factory->createAuth();
		$realtimeDatabase = $factory->createDatabase();
		return $realtimeDatabase;

	}
}
