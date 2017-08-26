<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test()
    {

        //
        $client = new \GuzzleHttp\Client();

        // REQUEST SIGNATURE
        $timestamp = date("yyyy-MM-ddTHH:mm:ss.SSSTZD");
        
        // $resp = $client->get('https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&key=AIzaSyAT65_OGp-KOIb8aTd9uc3Whh3IbYrVEAY');


        
        $resp = $client->request('POST', '/utilities/signature', [
            'headers' => [
                'Timestamp' => $timestamp,
                'URI' => '/banking/v2/corporates/BCAAPI2016/accounts/8220000011',
                'AccessToken' => 'MDBhMmNlY2YtNTdhOS00OTVkLWIzMzctMDUzNzk0ODFjZWEyOjkwZjg2NmYwLTBiYjEtNDE5Zi1iZmNjLWFiZDNjZTY1ZDBlMQ==',
                'APISecret' => '60766ed9-2480-4f47-ab3f-68a5a719b54d',
                'HTTPMethod' => 'GET',
            ]
        ]);

        echo $resp->getBody();


        // $request = $client->createRequest('GET', '/banking/v2/corporates/BCAAPI2016/accounts/8220000011');
        // $request->addHeader('X-Authorization', '');
        // $resp = $client->send($request);
        
    }

}
