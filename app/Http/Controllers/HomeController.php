<?php
namespace App\Http\Controllers;

use App\Rss;
use Illuminate\Http\Request;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;



class HomeController extends Controller{
    
    public function inicio() {        
        $data = Rss::all();
        return view('home')->with('data',$data);
    }
    
    public function recibir(Request $request){
        $str_logTxt = __CLASS__ . "->" . __FUNCTION__ . "::";
        $str_logTxt .= "queue_create::";
        
        
        $wines = $request->input("wines");
        $response = Rss::getPubDate($wines);
        $pubDate = $response->pubDate;
        
        try {
            $host = 'rhino.rmq.cloudamqp.com';
            $user = 'gnyafmqg';
            $pass = 'OSg0J453sOqd0hqmCkIDbIgXB9hYLdli';
            $port = 5672;
            $exchange = "subscribers";
            $queue ='waiters';
            $vhost = 'gnyafmqg';
            $connection = new AMQPStreamConnection($host, $port, $user, $pass, $vhost);
            if(!$connection->isConnected()){
                $str_logTxt .= "Connection_Failed";
                Log::error($str_logTxt);
                die('Connection through channel failed!');
            }
            $channel = $connection->channel();
            $channel->queue_declare($queue, false, true, false, false);
            
            $channel->exchange_declare($exchange, 'direct', false, true, false);
            $channel->queue_bind($queue, $exchange);
            $messageBody = json_encode([
                'title' => $wines,
                'pubDate' => $pubDate
            ]);
            
            $str_logTxt .= ("Body_Queue_Sent: $messageBody");
            Log::error($str_logTxt);
            $message = new AMQPMessage($messageBody, [
                'content_type' => 'application/json',
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
            $channel->basic_publish($message, $exchange);
            
            $channel->close();
            $connection->close();
        } catch (AMQPException $e) {
            $str_logTxt .="AMQP Exception - ".$e->getMessage();
            Log::error($str_logTxt);
        }
        Log::debug($str_logTxt);
        return view('principal')
        ->with('title' ,$wines);
        
    }
    
    public function show() {
        $str_logTxt = __CLASS__ . "->" . __FUNCTION__ . "::";
        $str_logTxt .= "consume::";
        try {
            // inputs
            $host = 'rhino.rmq.cloudamqp.com';
            $user = 'gnyafmqg';
            $pass = 'OSg0J453sOqd0hqmCkIDbIgXB9hYLdli';
            $port = 5672;
            $exchange = "subscribers";
            $queue ='waiters';
            $vhost = 'gnyafmqg';
            $login_method = 'AMQPLAIN';
            $locale = 'en_US';
            $connection_timeout = 3.0;
            $read_write_timeout = 300;
            $heartbeat = 60.0;
            
            $connection = new AMQPStreamConnection($host, $port, $user, $pass, $vhost,false,$login_method,null,$locale,$connection_timeout,$read_write_timeout, null, true, $heartbeat);
            $channel = $connection->channel();
            if(!$connection->isConnected()){
                $str_logTxt .= "Connection_Failed";
                Log::error($str_logTxt);
                die('Connection through channel failed!');
            }
            $channel->basic_qos(0, '<PREFET_COUNT>', false);
            
            $channel->queue_declare($queue, false, true, false, false);
            $channel->exchange_declare($exchange, 'direct', false, true, false);
            $channel->queue_bind($queue, $exchange);
            
            $callback = function (AMQPMessage $msg) {
                file_put_contents(storage_path().'/data/info.json', $msg->body);
                
                $str_logTxt = "messageBody : $msg->body";
                
                
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
                
                if ($msg->body === 'quit') {
                    $msg->delivery_info['channel']->basic_cancel($msg->delivery_info['consumer_tag']);
                }
                Log::debug($str_logTxt);
                
            };
            $consumerTag = 'local.acer.consumer';
            $channel->basic_consume($queue, $consumerTag, false, false, false, false, $callback);
            
            while (count($channel->callbacks)) {
                $channel->wait();
                return view('show');
                exit();
            }
            
            $channel->close();
            $connection->close();
            
        } catch (\AMQPException $e) {
            $error ="AMQP Exception - ".$e->getMessage();
            $str_logTxt .= "Error_exception: $error";
            Log::error($str_logTxt);
            
        }
        Log::debug($str_logTxt);
     }  
}

