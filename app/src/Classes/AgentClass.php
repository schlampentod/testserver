<?php

namespace App\Classes;
use App\Model\M_agentsDAO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \Blocktrail\SDK\BlocktrailSDK;
Class AgentClass extends Enpoint{
    
    

//************************ Members Crud ***************************
    public function allagents(Request $request, Response $response, $args) {
            
      //track request
                 
                $agents = new M_agentsDAO();
                
                $responsearray = $agents->view_all_agents();
                 return $this->render($response, $responsearray , 200);
                 
        
    }

    public function addagents(Request $request, Response $response, $args) {
            
      //track request
                 $data = $this->getRequest_data($request, $response);
                $agents = new M_agentsDAO();               
                $responsearray = $agents->add_agents($data);
                 return $this->render($response, $responsearray , 200);
                 
        
    }

    public function editagents(Request $request, Response $response, $args) {
            
      //track request
                 $data = $this->getRequest_data($request, $response);
                $members = new M_agentsDAO();   
                $data_array = array("members_firstname"=>$data->firstname , 
                                     "members_lastname"=>$data->lastname);            
                $responsearray = $members->edit_members($data_array , 2);
                 return $this->render($response, $responsearray , 200);
    }



    public function test(Request $request, Response $response, $args) {
            
     

    }


}
