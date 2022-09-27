<?php

namespace App\Http\Controllers\academic;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ClassController extends Controller
{
    public function index()
    {
            $classes =  DB::table('classes')->get()->keyBy('id');
            return response()->json($classes);
    }

    public function show($class_id)
    {
            $class = DB::table('classes')->where('id',$class_id)->first();
            return response()->json($class);
    }

    public function store(Request $request)
    {   
            $validator = Validator::make($request->all(), [
                'class_name' => 'required|max:255',
                'session_id' => 'required',
            ]);

            if(!$validator->fails())
            {

                try{
                    $created = DB::table('classes')->insert([
                        'class_name' => $request->class_name,  
                        'session_id' => $request->session_id,  
                    ]);

                    return response()->json([
                        'success' => true, 
                        'message' => 'class created successfully'
                    ]);

                }catch(Exception $e){

                    return response()->json([
                        'success' => false, 
                        'message' => 'class fail to create. Databse error occured',
                        'errors'  => $e
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

    public function update(Request $request,$class_id)
    {   
            $validator = Validator::make($request->all(), [
                'class_name' => 'required|max:255',
                'session_id' => 'required',
            ]);

            if(!$validator->fails())
            {

                try{
                    $created = DB::table('classes')
                    ->where('id',$class_id)
                    ->update([
                        'class_name' => $request->class_name,  
                        'session_id' => $request->session_id,  
                    ]);

                    return response()->json([
                        'success' => true, 
                        'message' => 'class updated successfully'
                    ]);

                }catch(Exception $e){

                    return response()->json([
                        'success' => false, 
                        'message' => 'class fail to update. Databse error occured',
                        'errors'  => $e
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

    public function delete($class_id)
    {
        $deleted = DB::table('classes')
                   ->where('id',$class_id)->delete();
        if($deleted){
            return response()->json([
                'success' => true,
                'message' => 'class deleted'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'class not deleted'
            ]);
        }           
    }

}
