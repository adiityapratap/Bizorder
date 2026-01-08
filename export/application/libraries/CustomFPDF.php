<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'third_party/fpdf.php');

class CustomFPDF extends FPDF
{

    function __construct()
    {
        parent::__construct();
        // require(APPPATH . 'third_party/makefont/makefont.php');
    }

    public function header()
    {
    }

    public function footer()
    {
    }

    public function getInstance()
    {
        return new CustomFPDF();
    }
}
