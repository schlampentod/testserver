<?php
namespace App\Model;

Class M_agentsDao {

    public function view_all_agents(){

        $members = M_agents::orderBy('created_at', 'desc')->get();
        return $members;
    }
    
    public function add_agents($data) {

            $members = new M_agents();
            $members->agent_firstname = $data->firstname;
            $members->agent_lastname  = $data->lastname;
            $members->agent_cellphone  = $data->cellphone;
            $members->agent_email  = $data->email;
            $members->save();
            return $members->id;
    }
    public function edit_agents($data , $id_members){

           $members = M_agents::where('id_members', '=', $id_members)
            ->update($data);
            return $members;
           
            

    }
   
}
