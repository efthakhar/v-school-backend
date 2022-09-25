<?php

namespace App\Http\Controllers\academic;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    public function index()
    {
            $sessions =  DB::table('sessions')->get()->keyBy('id');
            return response()->json($sessions);
    }

    public function show($session_id)
    {
            $session = DB::table('sessions')->where('id',$session_id)->first();
            return response()->json($session);
    }

    public function store(Request $request)
    {   
            $validator = Validator::make($request->all(), [
                'session_name' => 'required|unique:sessions|max:255',
                'session_code' => 'required|unique:sessions|max:255',
                'start_date' => 'required',
                'end_date' => 'required',
            ]);

            if(!$validator->fails())
            {

                try{
                    $created = DB::table('sessions')->insert([
                        'session_name' => $request->session_name,
                        'session_code' => $request->session_code,
                        'session_description' => $request->session_description,
                        'start_date'   => $request->start_date,
                        'end_date'     => $request->end_date,
                        'active_status'=>$request->active_status  
                    ]);

                    return response()->json([
                        'success' => true, 
                        'message' => 'session created successfully'
                    ]);

                }catch(Exception $e){

                    return response()->json([
                        'success' => false, 
                        'message' => 'session fail to create. Errors: '.$e
                    ]);
                }
                
            }else{

                return response()->json([
                    'success' => false, 
                    'message' => 'validation error occured',
                    'errors'  => $validator->errors(),
                ]);

            }
    }

    public function update(Request $request,$session_id)
    {   
            $validator = Validator::make($request->all(), [
                'session_name' => ['required','max:255',Rule::unique('sessions')->ignore($session_id)],
                'session_code' => ['required','max:255',Rule::unique('sessions')->ignore($session_id)],
                'start_date' => 'required',
                'end_date' => 'required',
            ]);

            if(!$validator->fails())
            {

                try{
                    $created = DB::table('sessions')
                    ->where('id',$session_id)
                    ->update([
                        'session_name' => $request->session_name,
                        'session_code' => $request->session_code,
                        'session_description' => $request->session_description,
                        'start_date'   => $request->start_date,
                        'end_date'     => $request->end_date,
                        'active_status'=>$request->active_status  
                    ]);

                    return response()->json([
                        'success' => true, 
                        'message' => 'session updated successfully'
                    ]);

                }catch(Exception $e){

                    return response()->json([
                        'success' => false, 
                        'message' => 'session fail to update. Errors: '.$e
                    ]);
                }
                
            }else{

                return response()->json([
                    'success' => false, 
                    'message' => 'validation error occured',
                    'errors'  => $validator->errors(),
                ]);

            }
    }

    public function delete($session_id)
    {
        $deleted = DB::table('sessions')
                   ->where('id',$session_id)->delete();
        if($deleted){
            return response()->json([
                'success' => true,
                'message' => 'session deleted'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'session not deleted'
            ]);
        }           
    }


}
