<?php 

// File: application/libraries/MY_Form_validation.php

class MY_Form_validation extends CI_Form_validation
{
    public function setControllerInstance($controller)
    {
        $this->CI = $controller;
    }
}
