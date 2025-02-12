<?php

namespace App\Services;

use App\Models\Product;
use SimpleXMLElement;

class FeedManagementService
{
    public static function getAllFeeds()
    {
        return [
            ['name' => 'Google Shopping Feed', 'type' => 'google'],
            ['name' => 'Facebook Catalog Feed', 'type' => 'facebook']
        ];
    }

    public static function generateFeed($feedType)
    {
        $products = Product::all();
        $xml = new SimpleXMLElement('<feed/>');
        $invalidProducts = [];

        foreach ($products as $product) {
            $cleanedProduct = self::cleanProductData($product);

            if (self::isValidProduct($cleanedProduct)) {
                $item = $xml->addChild('product');
                $item->addChild('id', $cleanedProduct['id']);
                $item->addChild('title', $cleanedProduct['title']);
                $item->addChild('price', $cleanedProduct['price']);
                $item->addChild('gtin', $cleanedProduct['gtin']);
                $item->addChild('custom_labels', self::applyCustomLabel($cleanedProduct));
            } else {
                $invalidProducts[] = [
                    'title' => $cleanedProduct['title'],
                    'error' => 'Missing or invalid data'
                ];
            }
        }

        return response($xml->asXML(), 200)->header('Content-Type', 'text/xml');
    }

    private static function applyCustomLabel($product)
    {
        $labels = [];

        // Revenue Label
        if ($product['roas'] > 5) {
            $labels[] = 'High Revenue';
        } elseif ($product['roas'] > 3) {
            $labels[] = 'Medium Revenue';
        } else {
            $labels[] = 'Low Revenue';
        }

        // Profitability Label
        if ($product['profit_margin'] > 20) {
            $labels[] = 'High Profit';
        } elseif ($product['profit_margin'] > 10) {
            $labels[] = 'Medium Profit';
        } else {
            $labels[] = 'Low Profit';
        }

        // CTR Label
        if ($product['ctr'] > 5) {
            $labels[] = 'High CTR';
        } elseif ($product['ctr'] > 2) {
            $labels[] = 'Medium CTR';
        } else {
            $labels[] = 'Low CTR';
        }

        // Trending Products
        if ($product['roas'] > 5 && $product['ctr'] > 5) {
            $labels[] = 'Upward Trend';
        } elseif ($product['roas'] < 2 && $product['ctr'] < 1) {
            $labels[] = 'Downward Trend';
        } else {
            $labels[] = 'Newcomer';
        }

        return implode(', ', $labels);
    }

    private static function cleanProductData($product)
    {
        return [
            'id' => trim($product->id),
            'title' => ucwords(strtolower(trim($product->title))), // Fix capitalization
            'price' => number_format($product->price, 2, '.', ''), // Ensure decimal format
            'gtin' => self::validateGTIN($product->gtin), // Validate GTIN
            'roas' => $product->roas ?? 0,
            'profit_margin' => $product->profit_margin ?? 0,
            'ctr' => $product->ctr ?? 0
        ];
    }

    private static function validateGTIN($gtin)
    {
        if (empty($gtin) || !ctype_digit($gtin) || strlen($gtin) < 8) {
            return 'Invalid GTIN';
        }
        return $gtin;
    }

    private static function isValidProduct($product)
    {
        return !empty($product['id']) && !empty($product['title']) && !empty($product['price']) && $product['price'] > 0;
    }
}
