<?php

namespace App\Http\Controllers\academic;

use App\Http\Controllers\Controller;
use App\Rules\CombineUnique;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ClassController extends Controller
{
    public function index(Request $request)
    {         
            $session_id = $request->query('session');

            $classes =  DB::table('classes')
            ->leftJoin('sessions', 'sessions.id', '=', 'classes.session_id')
            ->select('classes.*', 'sessions.session_name')
            ->when($session_id,function($query,$session_id){
                $query->where('session_id',$session_id);
            })
            ->paginate(10);
            
            return response()->json($classes);
    }

    public function show($class_id)
    {
            $class = DB::table('classes')
            ->join('sessions', 'sessions.id', '=', 'classes.session_id')
            ->select('classes.*', 'sessions.session_name')
            ->where('classes.id',$class_id)
            ->first();
            return response()->json($class);
    }

    public function store(Request $request)
    {   
            $validator = Validator::make($request->all(), 
            [
                'class_name' => 
                [
                    new CombineUnique(
                        [
                            ['class_name',$request->class_name],
                            ['session_id',$request->session_id],
                        ],
                        'classes',
                        'There can not two same name class under same session'
                    ),
                    'max:255',
                    'required'
                ],

                'session_id' => 'required',
            ],
            [ 
                'class_name.required' => ':attribute field can not be empty',
                'session_id.required' => 'session name is required',
            ]
            );

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
                    ],201);

                }catch(Exception $e){

                    return response()->json([
                        'success' => false, 
                        'message' => 'class fail to create. Databse error occured',
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
                    ],200);

                }catch(Exception $e){

                    return response()->json([
                        'success' => false, 
                        'message' => 'class fail to update. Databse error occured',
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
