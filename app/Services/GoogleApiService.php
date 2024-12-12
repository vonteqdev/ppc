<?php

namespace App\Services;

use Google_Client;
use Google_Service_Webmasters;
use Google_Service_Oauth2;
use Google_Service_Exception;
use Google\Service\GoogleAnalyticsAdmin;
use Google\Service\Analytics;
use stdClass;
use Google\Ads\GoogleAds\Lib\GoogleAdsBuilder;
use Google\Ads\GoogleAds\Lib\OAuth2TokenBuilder;
use App\Models\GoogleAccount;
use Google\Service\ShoppingContent;


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
            'https://www.googleapis.com/auth/content'
        ]);
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        // $client->setIncludeGrantedScopes(true); 
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
            GoogleAnalyticsAdmin::ANALYTICS_READONLY,
            Analytics::ANALYTICS_READONLY,
            'https://www.googleapis.com/auth/content'
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
                $propertyObj->id = $property->propertyId;
                $propertyObj->name = $property->name;
                $propertyObj->displayName = $property->displayName;
                $propertyObj->type = 'GA4';
                $propertyArray[] = $propertyObj;
            }
    
            foreach ($uaProperties->getItems() as $property) {
                $propertyObj = new \stdClass();
                $propertyObj->id = $property->getId();
                $propertyObj->name = $property->getName();
                $propertyObj->displayName = $property->getWebsiteUrl();
                $propertyObj->type = 'UA';
                $propertyArray[] = $propertyObj;
            }
    
            $accountObj->properties = $propertyArray;
            $accountsArray[] = $accountObj;
        }
    
        return $accountsArray;
    }

    public function getGoogleAdsClient($token) {
        $oauth2Credential = (new OAuth2TokenBuilder())
            ->withClientId(env('GOOGLE_CLIENT_ID'))
            ->withClientSecret(env('GOOGLE_CLIENT_SECRET'))
            ->withRefreshToken($token->refresh_token)
            ->build();

        return (new GoogleAdsBuilder())
            ->withDeveloperToken(env('GOOGLE_ADS_DEVELOPER_TOKEN'))
            ->withOAuth2Credential($oauth2Credential)
            ->build();
    }

    public function getProductClicksAndCPC($googleAdsClient, $customerId) {
        $googleAdsServiceClient = $googleAdsClient->getGoogleAdsServiceClient();
        $query = "SELECT segments.product_item_id, metrics.clicks, metrics.cost_micros, metrics.average_cpc FROM shopping_performance_view WHERE segments.date DURING LAST_30_DAYS";
    
        $response = $googleAdsServiceClient->search($customerId, $query);
    
        $productPerformance = [];
        foreach ($response->iterateAllElements() as $googleAdsRow) {
            /** @var GoogleAdsRow $googleAdsRow */
            $productPerformance[] = [
                'productItemId' => $googleAdsRow->getSegments()->getProductItemId(),
                'clicks' => $googleAdsRow->getMetrics()->getClicks(),
                'totalCost' => $googleAdsRow->getMetrics()->getCostMicros() / 1000000,
                'averageCPC' => $googleAdsRow->getMetrics()->getAverageCpc() / 1000000,
            ];
        }
    
        return $productPerformance;
    }


    // MERCHANT CENTER API
    public function listMerchantProducts($client, $merchantId) {
        $shoppingService = new ShoppingContent($client);
        $products = [];
        $nextPageToken = null;
    
        do {
            try {
                $response = $shoppingService->products->listProducts($merchantId, ['pageToken' => $nextPageToken]);
                foreach ($response->getResources() as $product) {
                    dd($product);
                    $products[] = [
                        'id' => $product->getId(),
                        'title' => $product->getTitle(),
                        'description' => $product->getDescription(),
                        'link' => $product->getLink(),
                        'imageLink' => $product->getImageLink(),
                        'price' => $product->getPrice(),
                        'brand' => $product->getBrand(),
                        'condition' => $product->getCondition(),
                        'availability' => $product->getAvailability(),
                        'gtin' => $product->getGtin(),
                        'mpn' => $product->getMpn(),
                        'googleProductCategory' => $product->getGoogleProductCategory(),
                        'expirationDate' => $product->getExpirationDate(),
                        'channel' => $product->getChannel(),
                        'contentLanguage' => $product->getContentLanguage(),
                        'targetCountry' => $product->getTargetCountry(),
                        'offerId' => $product->getOfferId(),
                        'salePrice' => $product->getSalePrice(),
                        'salePriceEffectiveDate' => $product->getSalePriceEffectiveDate(),
                        'unitPricingMeasure' => $product->getUnitPricingMeasure(),
                        'unitPricingBaseMeasure' => $product->getUnitPricingBaseMeasure(),
                    ];
                }
                $nextPageToken = $response->getNextPageToken();
            } catch (\Exception $e) {
                return 'Error: ' . $e->getMessage();
            }
        } while ($nextPageToken);
    
        return $products;
    }    
}