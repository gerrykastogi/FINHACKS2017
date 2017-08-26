<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
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

    public function getGroupById(int $id){
        $groupId = DB::table('users_groups')
                    ->where('user_id', '=', $id)
                    ->get();
        $arGroup = array(Group::where('id', '=', $groupId[0]->group_id)->first());
        for($i=1; $i<count($groupId); $i++){
            array_push($arGroup, Group::where('id', '=', $groupId[$i]->group_id)->first());
        }

        return response()->json($arGroup);
    }
}
