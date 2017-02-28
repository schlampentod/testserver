<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Classes;

/**
 * Description of Enpoint
 *
 * @author Simon.Pierre
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
class Enpoint {
    //put your code here
    
     public function __construct() {
       
   }
   public function render(Response $response, $data, $status_code) {
        return $response->withStatus((int) $status_code)
                        ->withHeader('Content-Type', 'application/json;charset=utf-8')
                        
                       ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                       ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                        ->withJson($data);
        
    }

    public function getRequest_data(Request $request , Response $response){
        if ($request->getBody() != "") {
            $data = json_decode($request->getBody());
            return $data;
        }else{
            return false;
        }
        
    }
    
    
}
