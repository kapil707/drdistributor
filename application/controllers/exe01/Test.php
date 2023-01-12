<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit','-1');
ini_set('post_max_size','500M');
ini_set('upload_max_filesize','500M');
ini_set('max_execution_time',36000);
class Test extends CI_Controller
{
    public function test_me()
    {
        //error_reporting(0);
        $data = (file_get_contents('php://input'));
        $items = $data["items"];
        print_r($items);
    }
}