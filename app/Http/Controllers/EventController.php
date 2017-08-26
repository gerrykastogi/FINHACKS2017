<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $groupId = $request->groupId;
        $events = Event::find($groupId);

        return response()->json($events);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $event = new Event();
        $event->group_id = $request->groupId;
        $event->name = $request->name;
        $event->deadline = $request->deadline;
        $members = $request->members;
        $event->save();

        for($i=0; $i<count($members); $i++){
            DB::table('users_events')->insert(
                ['user_id' => $members[$i]['id'] , 'event_id' => $event->id]
            ); 
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }

    public function getEventById(int $id){
        $eventId = DB::table('users_events')
                    ->where('user_id', '=', $id)
                    ->get();
        $arEvent = array(Event::where('id', '=', $eventId[0]->event_id)->first());
        for($i=1; $i<count($eventId); $i++){
            array_push($arEvent, Event::where('id', '=', $eventId[$i]->event_id)->first());
        }

        return response()->json($arEvent);
    }
}
