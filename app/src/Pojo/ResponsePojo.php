<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of responsePojo
 *
 * @author Simon.Pierre
 */
namespace App\Pojo;
class ResponsePojo {
    //put your code here
    public $success;
    public $error;
    public $error_code;
    function __construct($success, $error, $error_code) {
        $this->success = $success;
        $this->error = $error;
        $this->error_code = $error_code;
    }

    function getSuccess() {
        return $this->success;
    }

    function getError() {
        return $this->error;
    }

    function getError_code() {
        return $this->error_code;
    }

    function setSuccess($success) {
        $this->success = $success;
    }

    function setError($error) {
        $this->error = $error;
    }

    function setError_code($error_code) {
        $this->error_code = $error_code;
    }


}
