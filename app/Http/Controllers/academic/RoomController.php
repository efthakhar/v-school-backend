<?php

namespace App\Http\Controllers\academic;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function index()
    {
            $rooms =  DB::table('rooms')
                        ->join('buildings','buildings.id','=','rooms.building_id')
                        ->select('rooms.*','buildings.building_name')
                        ->orderBy('id','desc')
                        ->paginate(10);
            
            return response()->json($rooms);
    }

    public function show($room_id)
    {
            $room =  DB::table('rooms')
                          ->join('buildings','buildings.id','=','rooms.building_id')
                          ->select('rooms.*','buildings.building_name')
                          ->where('rooms.id',$room_id)
                          ->first();           
            return response()->json($room);
    }

    public function store(Request $request)
    {     

        $count = DB::table('rooms')->where([
            ['room_no',$request->room_no],
            ['building_id', $request->building_id],
        ])->count();

        if($count>0){

            return response()->json([
                'success' => false, 
                'message' => 'room fail to create',
                'errors' => [
                    'room_name'=>'room name duplicated',
                    'building_name'=>'building name duplicated',
                ] 
            ],401);

        }

        $created = DB::table('rooms')->insert([
            'room_name' => $request->room_name,  
            'room_no' => $request->room_no,  
            'building_id' => $request->building_id,              
        ]);

        if($created){

            return response()->json([
                'success' => true, 
                'message' => 'room created successfully'
            ],201);

        }else{

            return response()->json([
                'success' => false, 
                'message' => 'room fail to create. Databse error occured',
                'errors'  => 'server error'
            ],500);

        }         
            
    }



    public function update(Request $request,$room_id)
    {     

        $count = DB::table('rooms')->where([
            ['room_no',$request->room_no],
            ['building_id', $request->building_id],
        ])->count();

        if($count>0){

            return response()->json([
                'success' => false, 
                'message' => 'room fail to update',
                'errors' => [
                    'room_name'=>'room name duplicated',
                    'building_name'=>'building name duplicated',
                ] 
            ],401);

        }

        $updated = DB::table('rooms')
                ->where('id',$room_id)
                ->update([
                    'room_name' => $request->room_name,  
                    'room_no' => $request->room_no,  
                    'building_id' => $request->building_id,              
                ]);

        if($updated){

            return response()->json([
                'success' => true, 
                'message' => 'room updated successfully'
            ],201);

        }else{

            return response()->json([
                'success' => false, 
                'message' => 'room fail to update. Databse error occured',
                'errors'  => 'server error'
            ],500);

        }         
            
    }

    public function delete($room_id)
    {
        $deleted = DB::table('rooms')
                   ->where('id',$room_id)
                   ->delete();

        if($deleted){
            return response()->json([
                'success' => true,
                'message' => 'room deleted'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'room not deleted'
            ]);
        }           
    }

    





}
