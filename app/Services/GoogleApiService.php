<?php

namespace App\Services;

use Google_Client;
use Google_Service_Webmasters;
use Google_Service_Oauth2;
use Google_Service_Exception;

class GoogleApiService {
    

    public function initClient($token) {
        $client = new Google_Client();
        $client->setScopes([Google_Service_Webmasters::WEBMASTERS_READONLY, Google_Service_Oauth2::USERINFO_EMAIL, Google_Service_Oauth2::USERINFO_PROFILE]);
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->setAccessType('offline');
        $client->setAccessToken($token->access_token);
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($token->refresh_token);
            $token->access_token = $client->getAccessToken();
        } else {
            $token->access_token = $client->getAccessToken();
        }
        $token->save();
        return $client;
    }

    public function generateAuthLink() {
        $client = new Google_Client();
        $client->setScopes([Google_Service_Webmasters::WEBMASTERS_READONLY, Google_Service_Oauth2::USERINFO_EMAIL, Google_Service_Oauth2::USERINFO_PROFILE]);
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        return $client->createAuthUrl();
    }
}