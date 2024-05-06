<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\WebsitesDataTable;
use App\Services\GoogleApiService;
use Google_Client;
use Google_Service_Oauth2;
use App\Models\GoogleAccount;

class SetupController extends Controller
{
    public function index(WebsitesDataTable $dataTable)
    {
        return $dataTable->render('setup.index');
    }

    public function initAuth($type) {
        $google = new GoogleApiService();
        return redirect($google->generateAuthLink());
    }

    public function authCallback() {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token['access_token']);
        $oauth2 = new Google_Service_Oauth2($client);
        $userInfo = $oauth2->userinfo->get();
        $email = $userInfo->email;
        GoogleAccount::updateOrCreate([
            'user_id' => auth()->id(),
            'email' => $email
        ], [
            'access_token' => $token['access_token'],
            'refresh_token' => $token['refresh_token'],
            'type' => 'google',
            'user_id' => auth()->id(),
            'email' => $email
        ]);
        return redirect()->route('setup.index');
    }
}
