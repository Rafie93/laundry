<?php

return [

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'firebase' => [
        'api_key' => 'AIzaSyBKBPjpnddl5AfnxQgtWuTP-KKhlNsq2vI',
        'auth_domain' => 'office-coffee-f4475.firebaseapp.com',
        'database_url' => 'https://office-coffee-f4475-default-rtdb.asia-southeast1.firebasedatabase.app',
        'project_id' => 'office-coffee-f4475',
        'storage_bucket' => 'office-coffee-f4475.appspot.com',
        'messaging_sender_id' => '496766642306',
        'app_id' => '1:496766642306:web:0e364d126d801b8c362c9b',
        'measurement_id' => 'G-2T61HGFD2Q',
    ],

];
