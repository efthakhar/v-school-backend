<?php

namespace App\Http\Controllers\academic;

use App\Http\Controllers\Controller;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Rules\CombineUnique;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;


class SectionController extends Controller
{
    function index(Request $request)
    {
            $page = $request->query('page');
            $session_id  = $request->query('session_id');
            $class_id    = $request->query('class_id');

            $sections = DB::table('sections')
                        ->leftJoin( 'classes',  'classes.id',  '=', 'sections.class_id' )
                        ->leftJoin( 'sessions', 'sessions.id', '=', 'sections.session_id' )
                        ->leftJoin( 'rooms', 'rooms.id', '=', 'sections.room_id' )
                        ->leftJoin( 'buildings', 'buildings.id', '=', 'rooms.building_id' )
                        ->select(
                            'sections.*', 'classes.class_name', 
                            'sessions.session_name',
                            'rooms.room_no',
                            'buildings.building_name'
                        )
                        ->when($session_id,function($query,$session_id){
                            $query->where('sections.session_id',$session_id);
                        })
                        ->when($class_id,function($query,$class_id){
                            $query->where('class_id',$class_id);
                        });


            $sections = $page ? $sections->orderBy('id','desc')->paginate(10) 
                             :$sections->orderBy('id','desc')->get();
            
            return response()->json($sections);
    }

    
    function show($section_id)
    {
            $section = DB::table('sections')
            ->leftJoin( 'classes',  'classes.id',  '=', 'sections.class_id' )
            ->leftJoin( 'sessions', 'sessions.id', '=', 'classes.session_id' )
            ->select('sections.*', 'classes.class_name', 'sessions.session_name')
            ->where('sections.id',$section_id)
            ->first();
           
            return response()->json($section);
    }

    
    public function store(Request $request)
    {   

        try{

            $validator = Validator::make($request->all(), 
            [
                 
                'section_name' =>   [
                                        new CombineUnique(
                                            [
                                                ['section_name',$request->section_name],
                                                ['class_id',$request->class_id],
                                                ['session_id',$request->session_id],
                                            ],
                                            'sections',
                                            'section, class and session must be combinely unique'
                                        ),
                                        'max:255',
                                        'required',
                                        
                                    ],

                'session_id'  => 'required',
                'class_id'    => 'required',
            ],
            [ 
                'section_name.required' => 'section field is required',
                'session_id.required'   => 'session field is required',
                'class_id.required'     => 'class field is required',
            ]
            );

            if($validator->fails()) {
                throw new ValidationException($validator);
            }

            $created = DB::table('sections')->insert([
                'section_name' => $request->section_name,  
                'class_id' => $request->class_id,
                'session_id' => $request->session_id,   
            ]);

            

            return response()->json([
                'success' => true, 
                'message' => 'class created successfully'
            ],201);

        }catch(ValidationException $e){

        
            return response()->json([
                'success' => false, 
                'message' => 'validation error occured',
                'errors'  => $e->errors(),
            ],422);
            

        }catch(QueryException $e){
            
            return response()->json([
                'success' => false, 
                'message' => 'databse error occured',
                'errors'  => $e->errorInfo
            ],500);
        }
             
    }

    public function update(Request $request,$section_id)
    {   

        try{

            $validator = Validator::make($request->all(), 
            [
                 
                'section_name' =>   [
                                        new CombineUnique(
                                            [
                                                ['section_name',$request->section_name],
                                                ['class_id',$request->class_id],
                                                ['session_id',$request->session_id],
                                            ],
                                            'sections',
                                            'section, class and session must be combinely unique',
                                            $section_id
                                        ),
                                        'max:255',
                                        'required',
                                        
                                    ],

                'session_id'  => 'required',
                'class_id'    => 'required',
            ],
            [ 
                'section_name.required' => 'section field is required',
                'session_id.required'   => 'session field is required',
                'class_id.required'     => 'class field is required',
            ]
            );

            if($validator->fails()) {
                throw new ValidationException($validator);
            }

            $created = DB::table('sections')
                        ->where('id',$section_id)
                        ->update([
                            'section_name' => $request->section_name,  
                            'class_id'     => $request->class_id,
                            'session_id'   => $request->session_id,   
                            'room_id'      => $request->room_id,   
                        ]);

            

            return response()->json([
                'success' => true, 
                'message' => 'class updated successfully'
            ],201);

        }catch(ValidationException $e){

        
            return response()->json([
                'success' => false, 
                'message' => 'validation error occured',
                'errors'  => $e->errors(),
            ],422);
            

        }catch(QueryException $e){
            
            return response()->json([
                'success' => false, 
                'message' => 'databse error occured',
                'errors'  => $e->errorInfo
            ],500);
        }
        
            
    }

    public function delete($section_id)
    {
        $deleted = DB::table('sections')
                   ->where('id',$section_id)
                   ->delete();

        if($deleted){
            return response()->json([
                'success' => true,
                'message' => 'section deleted successfully'
            ],201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'fail to delete section'
            ],404);
        }           
    }

}
