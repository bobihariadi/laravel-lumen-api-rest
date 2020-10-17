<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       //
    }

    public function getSimple(){
        $url = "https://postman-echo.com/get";        
        $options = array(
            'name' => 'Bobi Hariadi',
            'sex' => 'Male' 
        );

        $response = Http::get($url, $options)->throw();

        return ["status"=>$response->ok(),"result"=>$response->json()];
    }

    public function getBasic(){
        $url = "https://postman-echo.com/basic-auth";        
        $options = array(
            'name' => 'Bobi Hariadi',
            'sex' => 'Male' 
        );

        $username = "postman";
        $password = "password";

        $response = Http::withBasicAuth($username, $password)->get($url, $options)->throw();

        return ["status"=>$response->ok(),"result"=>$response->json()];
    }

    public function getApiKey(){
        $url = "http://newsapi.org/v2/top-headlines";        
        $options = array(
            'sources' => 'techcrunch',
            'apiKey' => 'c1702dd4eccf41f8b5a32efe4781ab1d' 
        );

        $response = Http::get($url, $options)->throw();

        return ["status"=>$response->ok(),"result"=>$response->json()];
    }  


    public function postSimple(){
        $url = "https://postman-echo.com/post";        
        $options = array(            
            'name' => 'Bobi Hariadi',
            'sex' => 'Male' 
        );

        $response = Http::post($url, $options)->throw();

        return ["status"=>$response->ok(),"result"=>$response->json()];
    }
    
    public function postBearer(){
        $url = "your url api";        
        $options = array(            
            'name' => 'Bobi Hariadi',
            'sex' => 'Male' 
        );

        $token = "your token/jwt";
        $response = Http::withToken($token)->post($url, $options)->throw();

        return ["status"=>$response->ok(),"result"=>$response->json()];
    }

}
