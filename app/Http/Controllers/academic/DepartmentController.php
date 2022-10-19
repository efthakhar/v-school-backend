<?php

namespace App\Http\Controllers\academic;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
            $page = $request->query('page');
            $search_string = $request->query('department_name');

            $departments =  DB::table('departments')
                            ->when($search_string,function($query,$search_string){
                                $query->where('department_name','LIKE', '%'.$search_string.'%');
                            });
                            
            $departments = $page ? $departments->orderBy('id','desc')->paginate(10) 
            :$departments->orderBy('id','desc')->get();

            return response()->json($departments);
    }
    public function show($department_id)
    {
            $department =  DB::table('departments')
                          ->where('id',$department_id)
                          ->first();           
            return response()->json($department);
    }

    public function store(Request $request)
    {   

                try{

                    $validator = Validator::make(
                        $request->all(), 
                        ['department_name' => 'required|unique:departments'],
                        ['department_name.required' => 'department field can not be empty',]
                    );

                    if($validator->fails()) {
                       throw new ValidationException($validator);
                    }

                    $created = DB::table('departments')->insertGetId([
                        'department_name' => $request->department_name, 
                    ]);

                    return response()->json([
                        'success' => true, 
                        'message' => 'departmen created successfully', 
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
                        'message' => 'Databse  error occured',
                        'errors'  => $e->errorInfo
                    ],500);
                }
                
            
    }
    public function update(Request $request,$department_id)
    {   

                try{

                    $validator = Validator::make(
                        $request->all(), 
                        ['department_name' => 
                            [ 'required',
                              'max:255',
                               Rule::unique('departments')->ignore($department_id)
                            ]
                       ],
                       ['department_name.required' => 'department field can not be empty',]
                    );

                    if($validator->fails()) {
                       throw new ValidationException($validator);
                    }

                    $updated = DB::table('departments')
                    ->where('id',$department_id)
                    ->update([
                        'department_name' => $request->department_name, 
                    ]);

                    return response()->json([
                        'success' => true, 
                        'message' => 'departmen updated successfully', 
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
                        'message' => 'Databse  error occured',
                        'errors'  => $e->errorInfo
                    ],500);
                }
                
            
    }
    public function delete($department_id)
    {
        $deleted = DB::table('departments')
                   ->where('id',$department_id)->delete();
        if($deleted){
            return response()->json([
                'success' => true,
                'message' => 'depertment  deleted'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'depertment not deleted'
            ]);
        }           
    }
}
