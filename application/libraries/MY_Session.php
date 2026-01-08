<?php

// File: application/libraries/MY_Session.php

class MY_Session extends CI_Session
{
    public function setControllerInstance($controller)
    {
        $this->CI = $controller;
    }
}


?>