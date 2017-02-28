<?php
  namespace App\Classes;
  use App\Model\M_Setting;

   Class SettingClass { 

          
              public function get($group , $key){
                 
                 $data3 = M_Setting::where('group', '=', $group)
                            ->where('key' , '=' , $key)
   							->select("value")
   							->first();

                  return $data3->value; 


              }
 






   }