<?php

namespace App\Http\Controllers\academic;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BuildingController extends Controller
{
    public function index()
    {
            $buildings =  DB::table('buildings')->paginate(10);
            
            return response()->json($buildings);
    }

    public function show($building_id)
    {
            $building =  DB::table('buildings')
                          ->where('id',$building_id)
                          ->first();           
            return response()->json($building);
    }


    public function store(Request $request)
    {   
            $validator = Validator::make($request->all(), [
                'building_name'     => 'required|max:255|unique:buildings',
                'building_location' => 'max:255',
            ]);

            if(!$validator->fails())
            {

                try{
                    $created = DB::table('buildings')->insert([
                        'building_name' => $request->building_name,  
                        'building_location' => $request->building_location,        
                    ]);

                    return response()->json([
                        'success' => true, 
                        'message' => 'building added successfully'
                    ],201);

                }catch(Exception $e){

                    return response()->json([
                        'success' => false, 
                        'message' => 'Databse error occured',
                        'errors'  => $e
                    ],500);
                }
                
            }else{

                return response()->json([
                    'success' => false, 
                    'message' => 'validation error occured',
                    'errors'  => $validator->errors(),
                ],401);

            }
    }

    public function update(Request $request,$building_id)
    {   
        
            $validator = Validator::make($request->all(), [
                'building_name' => ['required','max:255',Rule::unique('buildings')->ignore($building_id)],
                'building_location' => 'max:255',
            ]);

            if(!$validator->fails())
            {

                try{
                    $created = DB::table('buildings')
                    ->where('id',$building_id)
                    ->update([
                        'building_name' => $request->building_name,  
                        'building_location' => $request->building_location,        
                    ]);

                    return response()->json([
                        'success' => true, 
                        'message' => 'building updated successfully'
                    ],201);

                }catch(Exception $e){

                    return response()->json([
                        'success' => false, 
                        'message' => 'Databse error occured',
                        'errors'  => $e
                    ],500);
                }
                
            }else{

                return response()->json([
                    'success' => false, 
                    'message' => 'validation error occured',
                    'errors'  => $validator->errors(),
                ],401);

            }
    }


    public function delete($building_id)
    {
        $deleted = DB::table('buildings')
                   ->where('id',$building_id)->delete();
        if($deleted){
            return response()->json([
                'success' => true,
                'message' => 'building deleted'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'building not deleted'
            ]);
        }           
    }


}
