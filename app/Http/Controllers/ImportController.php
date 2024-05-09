<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function importXML(Request $request) {
        $request->validate([
            'url' => 'required|url'
        ]);
        $url = $request->input('url');
        $xml = simplexml_load_file($url, "SimpleXMLElement", LIBXML_NOCDATA);
        $items = [];
        foreach ($xml->channel->item as $item) {
            $namespaces = $item->getNameSpaces(true);
            $g = $item->children($namespaces['g']);
            
            $itemData = [
                'title' => (string) $item->title,
                'description' => (string) $item->description,
                'link' => (string) $item->link,
                'id' => (string) $g->id,
                'product_type' => (string) $g->product_type,
                'image_link' => (string) $g->image_link,
                'condition' => (string) $g->condition,
                'availability' => (string) $g->availability,
                'price' => (string) $g->price,
                'brand' => isset($g->brand) ? (string) $g->brand : null,
                'google_product_category' => (string) $g->google_product_category,
                'tax' => [
                    'country' => (string) $g->tax->country,
                    'rate' => (float) $g->tax->rate,
                    'tax_ship' => (string) $g->tax->tax_ship
                ],
                'shipping' => [
                    'country' => (string) $g->shipping->country,
                    'price' => (string) $g->shipping->price
                ]
            ];
            $items[] = $itemData;
        }

        return response()->json(['success'=>true, 'data'=>$items]);
    }
}
