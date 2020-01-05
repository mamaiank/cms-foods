<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: ZTOP
 * Date: 22/10/2559
 * Time: 21:53
 */
class MY_Input extends CI_Input
{
    function _sanitize_globals()
    {
        $this->allow_get_array = TRUE;
        parent::_sanitize_globals();
    }
}