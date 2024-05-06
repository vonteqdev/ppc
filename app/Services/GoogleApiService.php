<?php

namespace App\Services;

use Google_Client;
use Google_Service_Webmasters;
use Google_Service_Oauth2;
use Google_Service_Exception;
use Google\Service\GoogleAnalyticsAdmin;
use Google\Service\Analytics;
use stdClass;


class GoogleApiService {
    

    public function initClient($token) {
        $client = new Google_Client();
        $client->setScopes([
            Google_Service_Webmasters::WEBMASTERS_READONLY,
            Google_Service_Oauth2::USERINFO_EMAIL,
            Google_Service_Oauth2::USERINFO_PROFILE,
            'https://www.googleapis.com/auth/analytics',
            'https://www.googleapis.com/auth/analytics.readonly',
            GoogleAnalyticsAdmin::ANALYTICS_READONLY,
            Analytics::ANALYTICS_READONLY,
        ]);
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->setAccessType('offline');
        $client->setAccessToken($token->access_token);
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($token->refresh_token);
            $token->access_token = $client->getAccessToken()['access_token'];
        } else {
            $token->access_token = $client->getAccessToken()['access_token'];
        }
        $token->save();
        return $client;
    }

    public function generateAuthLink() {
        $client = new Google_Client();
        $client->setScopes([
            Google_Service_Webmasters::WEBMASTERS_READONLY,
            Google_Service_Oauth2::USERINFO_EMAIL,
            Google_Service_Oauth2::USERINFO_PROFILE,
            'https://www.googleapis.com/auth/analytics',
            'https://www.googleapis.com/auth/analytics.readonly',
        ]);
        $client->setApprovalPrompt('force');
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        return $client->createAuthUrl();
    }

    public function getAccounts($client) {
        $analytics = new Analytics($client);
        $accounts = $analytics->management_accounts->listManagementAccounts();

        $accountsArray = [];
        foreach ($accounts->getItems() as $account) {
            $accountObj = new \stdClass();
            $accountObj->id = $account->getId();
            $accountObj->displayName = $account->getName();
            $accountsArray[] = $accountObj;
        }
        return $accountsArray;
    }

    public function getAccountsAndProperties($client) {
        $analyticsAdmin = new GoogleAnalyticsAdmin($client);
        $analytics = new Analytics($client);
    
        $accounts = $analyticsAdmin->accounts->listAccounts();
        $accountsArray = [];
    
        foreach ($accounts as $account) {
            $accountObj = new \stdClass();
            $accountObj->name = $account->name;
            $accountObj->displayName = $account->displayName;
    
            $ga4Properties = $analyticsAdmin->properties->listProperties(['filter' => 'parent:' . $account->name]);
    
            $accountId = str_replace('accounts/', '', $account->name);
            $uaProperties = $analytics->management_webproperties->listManagementWebproperties($accountId);
    
            $propertyArray = [];
    
            foreach ($ga4Properties as $property) {
                $propertyObj = new \stdClass();
                $propertyObj->name = $property->name;
                $propertyObj->displayName = $property->displayName;
                $propertyObj->type = 'GA4';
                $propertyArray[] = $propertyObj;
            }
    
            foreach ($uaProperties->getItems() as $property) {
                $propertyObj = new \stdClass();
                $propertyObj->id = $property->getId();
                $propertyObj->name = $property->getName();
                $propertyObj->type = 'UA';
                $propertyArray[] = $propertyObj;
            }
    
            $accountObj->properties = $propertyArray;
            $accountsArray[] = $accountObj;
        }
    
        return $accountsArray;
    }
}