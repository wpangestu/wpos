<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_cart extends CI_Cart
{
    function __construct(){
        parent::__construct();
        $this->product_name_rules = '\d\D';
    }
}