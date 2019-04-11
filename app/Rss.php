<?php
namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class Rss extends Model {
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'wine';
    
    protected $fillable = ['title','pubDate'];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];
    
    public static function getTitle(){
        $str_logTxt = __CLASS__ . "->" . __FUNCTION__ . "::";
        $str_logTxt .= "REQUEST_GET_TITLE::";
        
        $arr_event = DB::select("SELECT * FROM wine");
        
        $str_logTxt .= "RESPONSE_getWineTitle" . json_encode($arr_event);
        Log::debug($str_logTxt);
        
        return current($arr_event);
    }
    public static function getPubDate($title){
        $str_logTxt = __CLASS__ . "->" . __FUNCTION__ . "::";
        $str_logTxt .= "REQUEST_GET_PubDate::title:$title;\n";
        
        $arr_event = DB::select("SELECT pubDate FROM wine where title=:title", ['title' => $title]);
        
        $str_logTxt .= "RESPONSE_getPubDate" . json_encode($arr_event);
        Log::debug($str_logTxt);
        
        #return response()->json($arr_event);
        return current($arr_event);
    }
    
    
}