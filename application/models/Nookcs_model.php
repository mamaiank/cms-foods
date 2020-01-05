<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nookcs_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getDataMultiLanguage($data_th,$data_en)
    {
        $value = 'null';
        if($_SESSION['language'] == 'Thai'){
            if($data_th){
                $value = $data_th;
            } else {
                $value = $data_en;
            }
        } else {
            if($data_en){
                $value = $data_en;
            } else {
                $value = $data_th;
            }
        }
        return $value;
    }
    function checkDataMultiLanguage($data_th,$data_en)
    {
        $value = 'null';
        if($_SESSION['language'] == 'Thai'){
            if($data_th){
                $value = $data_th;
            } else {
                $value = $data_en;
            }
        } else {
            if($data_en){
                $value = $data_en;
            } else {
                $value = $data_th;
            }
        }
        return $value;
    }

}