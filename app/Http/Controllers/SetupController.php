<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\WebsitesDataTable;
use App\Services\GoogleApiService;
use Google_Client;
use Google_Service_Oauth2;
use App\Models\GoogleAccount;
use App\Models\GoogleAnalyticsProperty;
use App\Models\Website;

class SetupController extends Controller
{
    public function index(WebsitesDataTable $dataTable)
    {
        // $token = GoogleAccount::where('user_id', auth()->id())->first();
        // if ($token) {
        //     $google = new GoogleApiService();
        //     $client = $google->initClient($token);
        //     dd($google->getAccountsAndProperties($client));
        //     // $client = $google->initClient($token);
        //     // // good id: 104825572
        //     // dd($google->listMerchantProducts($client, '3222'));
        // }
        return $dataTable->render('setup.index');
    }

    public function removeAccount() {
        auth()->user()->google_account()->delete();
        return response()->json(['success' => true, 'message' => 'Account removed successfully']);
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
        $googleAccount = GoogleAccount::updateOrCreate([
            'user_id' => auth()->id(),
            'email' => $email
        ], [
            'access_token' => $token['access_token'],
            'refresh_token' => $token['refresh_token'],
            'type' => 'google',
            'user_id' => auth()->id(),
            'email' => $email
        ]);

        $google = new GoogleApiService();
        $client = $google->initClient($googleAccount);
        $accounts = $google->getAccountsAndProperties($client);
        if ($accounts) {
            $this->createAnalyticsPropertiesAndAccounts($accounts, $googleAccount);
        }

        return redirect()->route('setup.index');
    }

    private function createAnalyticsPropertiesAndAccounts($accounts, $googleAccount) {
        foreach ($accounts as $account) {
            $accountId = str_replace('accounts/', '', $account->name);
            $analyticAccount = $googleAccount->analyticsAccounts()->updateOrCreate([
                'google_account_id' => $googleAccount->id,
                'account_id' => $accountId,
                'name' => $account->name,
                'display_name' => $account->displayName
            ], [
                'google_account_id' => $googleAccount->id,
                'account_id' => $accountId,
                'name' => $account->name,
                'display_name' => $account->displayName
            ]);
            if (isset($account->properties)) {
                foreach ($account->properties as $property) {
                    if ($property->type === 'GA4') {
                        $propertyId = str_replace('properties/', '', $property->name);
                    } else {
                        $propertyId = $property->id;
                    }
                    $analyticAccount->properties()->updateOrCreate([
                        'google_analytics_account_id' => $analyticAccount->id,
                        'property_id' => $propertyId,
                        'name' => $property->name,
                        'display_name' => $property->displayName,
                        'type' => $property->type
                    ], [
                        'google_analytics_account_id' => $analyticAccount->id,
                        'property_id' => $propertyId,
                        'name' => $property->name,
                        'display_name' => $property->displayName,
                        'type' => $property->type
                    ]);
                }
            }
        }
    }

    public function getProperties($token) {
        $google = new GoogleApiService();
        $client = $google->initClient($token);
        return $google->getAccountsAndProperties($client);
    }

    public function addWebsite(Request $request) {
        $request->validate([
            'website_url' => 'required|url',
            'feed_url' => 'required|url',
            'google_property' => 'required|exists:google_analytics_properties,id'
        ]);

        $googleProperty = GoogleAnalyticsProperty::find($request->google_property);
        $getOnlyTheHost = parse_url($request->website_url, PHP_URL_HOST);
        $website = Website::create([
            'user_id' => auth()->id(),
            'name' => $getOnlyTheHost,
            'url' => $request->website_url,
            'feed_url' => $request->feed_url,
            'google_analytics_property_id' => $googleProperty->id
        ]);

        return response()->json(['success' => true, 'message' => 'Website added successfully', 'website' => $website]);
    }

    public function removeWebsite(Website $website) {
        if ($website->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }
        $website->delete();
        return response()->json(['success' => true, 'message' => 'Website removed successfully']);
    }
}
