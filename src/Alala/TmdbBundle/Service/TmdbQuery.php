<?php
namespace Alala\TmdbBundle\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class TmdbQuery
{
    private $configs;
    
    public function __construct($configs){
        $this->configs = $configs;
    }
    
    public function request($request){
        
        $url = $this->configs['url'] . $request['url']['link'];
        
        foreach($request['url'] as $key => $elem){
            if($key !== 'link'){
                $url .= '/' .$elem;
            }
        }
        
        if(!is_array($request['parameters'])){
            $params = [];
        }
        
        $request['parameters']['api_key'] = $this->configs['apikey'];
        
        $client = new Client();
        $response = $client->get($url, [
            'query' =>  $request['parameters'],
            'decode_content' => true
            
        ]);
        
        $body = $response->getBody();

        $bodyContent = json_decode($body->getContents(), true);
        if(isset($bodyContent['results'])){
            return $bodyContent['results'];
        }else{
            return [$bodyContent];
        }
    }
}

