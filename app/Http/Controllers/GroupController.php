<?php

namespace App\Http\Controllers;

use App\Group;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $group = new Group();
        $group->name = $request->name;
        $members = $request->members;
        $group->total_member = count($members);
        $group->save();

        for($i=0; $i<count($members); $i++){
            DB::table('users_groups')->insert(
                ['user_id' => $members[$i]['id'] , 'group_id' => $group->id]
            ); 
        }

        return "success";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $groupId = $request->id;
        $group = Group::find($groupId);
        $group->name = $request->name;
        $group->save();
    }

    public function addMember(Request $request) {

        //
        $groupId = $request->groupId;
        $group = Group::find($groupId);
        $members = $request->members;
        $group->total_member += count($members);
        for($i=0; $i<count($members); $i++){
           DB::table('users_groups')->insert(
                ['user_id' => $members[$i]['id'] , 'group_id' => $group->id]
            ); 
        }

        $group->save();   
        return "success";
    }

    public function removeMember(Request $request) {

        //
        $groupId = $request->groupId;
        $userId = $request->userId;
        $group = Group::find($groupId);
        $group->total_member -= 1;
        $group->save();   

        // remove from user_group table
        DB::table('users_groups')
            ->where('user_id', '=', $userId)
            ->where('group_id', '=', $groupId)
            ->delete(); 

        return "success";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        //
    }

    public function test(){
        $client = new Client();
        // $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&key=AIzaSyAT65_OGp-KOIb8aTd9uc3Whh3IbYrVEAY";

        // $response = $client->get($url);
        
        // $body = $response->getBody();

        // echo $body;
        $timestamp = date("yyyy-MM-ddTHH:mm:ss.SSSTZD");
        
        $resp = $client->get("/banking/v2/corporates/h2hauto009/accounts/0611104625") 
        // $resp = $client->request('POST', 'http://127.0.0.1:8001/utilities/signature', [
        //     'headers' => [
        //         'Timestamp' => '2017-08-26T09:14:49+00:00',
        //         'URI' => '/banking/v2/corporates/BCAAPI2016/accounts/8220000011',
        //         'AccessToken' => 'MDBhMmNlY2YtNTdhOS00OTVkLWIzMzctMDUzNzk0ODFjZWEyOjkwZjg2NmYwLTBiYjEtNDE5Zi1iZmNjLWFiZDNjZTY1ZDBlMQ==',
        //         'APISecret' => '60766ed9-2480-4f47-ab3f-68a5a719b54d',
        //         'HTTPMethod' => 'GET'
        //     ]
        // ]);


        return "success";
    }
}
