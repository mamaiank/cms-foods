<?php
/**
 * Created by PhpStorm.
 * User: ZTOP
 * Date: 18/12/2559
 * Time: 17:55
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ztopy_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getProvinceName($province_id)
    {
        $province_name = $this->db->get_where('provinces', array(
            'PROVINCE_ID' => $province_id
        ))->row();
        $provinces = $province_name->PROVINCE_NAME." / ".$province_name->PROVINCE_NAME_ENG;
        return $provinces;
    }

}