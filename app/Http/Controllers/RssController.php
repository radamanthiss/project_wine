<?php

namespace App\Http\Controllers;

use App\Rss;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class RssController extends Controller
{
    public function readRss(Request $request) {
        $str_LogTxt = __CLASS__ ."->". __FUNCTION__ ."::";
        $str_LogTxt .= "REQUEST: ". json_encode($request->toArray()). ";";
        try{
            $update = DB::table('wine')->truncate();
            
            $feed = file_get_contents($request->url);
            $rss = simplexml_load_string($feed);
            
            foreach ($rss->channel->item as $item){
                
                $date = new \DateTime((string)$item->pubDate);
                $save_rss = DB::table('wine')->insert([
                    'title' => (string)$item->title,
                    'pubDate' => $date->format('Y-m-d H:i:s'),
                    'created_at' => date("Y-m-d h:m:s"),
                    'updated_at' => date("Y-m-d h:m:s")
                ]);
            }
            $str_LogTxt .= "RESPONSE_TRUNCATE: " . json_encode($update) . ";";
            Log::debug($str_LogTxt);
            
        }catch (\Exception $e){
            $str_LogTxt .= "[ERROR= " . $e->getMessage() . "];";
            Log::debug($str_LogTxt);
            return response()->json(['error' => 'Internal server error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
            
        }
        $str_LogTxt .= "RESPONSE_createNewWine: " . json_encode($save_rss) . ";";
        Log::debug($str_LogTxt);
        return response()->json($save_rss);
    }
    public function updateWine(Request $request) {
        $str_LogTxt = __CLASS__ ."->". __FUNCTION__ ."::";
        $str_LogTxt .= "REQUEST: ". json_encode($request->toArray()). ";";
        try {
            $update = DB::table('wine')->truncate();
            
            $feed = file_get_contents($request->url);
            $rss = simplexml_load_string($feed);
            foreach ($rss->channel->item as $item){
                
                $date = new \DateTime((string)$item->pubDate);
                $save_rss = DB::table('wine')->insert([
                    'title' => (string)$item->title,
                    'pubDate' => $date->format('Y-m-d H:i:s'),
                    'created_at' => date("Y-m-d h:m:s"),
                    'updated_at' => date("Y-m-d h:m:s")
                ]);
            }
            $str_LogTxt .= "RESPONSE_TRUNCATE: " . json_encode($update) . ";";
            Log::debug($str_LogTxt);
            
        } catch (\Exception $e) {
            $str_LogTxt .= "[ERROR= " . $e->getMessage() . "];";
            Log::debug($str_LogTxt);
            return response()->json(['error' => 'Internal server error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $str_LogTxt .= "RESPONSE_UpdateWine: " . json_encode($save_rss) . ";";
        Log::debug($str_LogTxt);
        return response()->json($save_rss);
    }
}
