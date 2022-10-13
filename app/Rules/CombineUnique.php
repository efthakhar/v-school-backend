<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CombineUnique implements Rule
{
    public $pairs = [];
    public $table = '';
    public $message = '';
    public $ignore_id = '';

    public function __construct($pairs,$table,$message,$ignore_id='')
    {
        
        $this->pairs = $pairs;
        $this->table = $table;
        $this->message = $message;
        $this->ignore_id = $ignore_id;
       
    }

    
    public function passes($attribute, $value)
    {
        if($this->ignore_id){
            //  dd($this->ignore_id);
            $count = DB::table($this->table)
                    ->where($this->pairs)
                    ->where('id','!=',$this->ignore_id)
                    ->count();

            if($count>0)
            {
                return false;
            }else
            {
                return true;
            }
           
        }else{
           // dd($this->ignore_id);
            $count = DB::table($this->table)
                    ->where($this->pairs)
                    ->count();

            if($count>0)
            {
                return false;
            }else
            {
                return true;
            }

        }
        
    }

    
    public function message()
    {
       
        return $this->message;
    }
}
