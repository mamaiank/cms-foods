<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Email_model extends CI_Model
{

    /*	
	 *	Developed by: Active IT zone
	 *	Date	: 14 July, 2015
	 *	Active Supershop eCommerce CMS
	 *	http://codecanyon.net/user/activeitezone
	 */

    function __construct()
    {
        parent::__construct();
    }


    function password_reset_email($account_type = '', $id = '', $pass = '')
    {
        $this->load->database();
        $system_name = $this->db->get_where('general_settings', array(
            'type' => 'system_name'
        ))->row()->value;
        $system_email = $this->db->get_where('general_settings', array(
            'type' => 'system_email'
        ))->row()->value;

        $query = $this->db->get_where($account_type, array(
            $account_type . '_id' => $id
        ));
        if ($query->num_rows() > 0) {
            $email_msg = "Your account type is : " . $account_type . "<br />";
            $email_msg .= "Your password is : " . $pass . "<br />";
            $email_sub = "Password reset request";
            $from = $system_email;
            $from_name = $system_name;
            $email_to = $query->row()->email;
            $this->do_email($email_msg, $email_sub, $email_to, $from);
            return true;
        } else {
            return false;
        }
    }

    function status_email($account_type = '', $id = '')
    {
        $this->load->database();
        $system_name = $this->db->get_where('general_settings', array(
            'type' => 'system_name'
        ))->row()->value;
        $system_email = $this->db->get_where('general_settings', array(
            'type' => 'system_email'
        ))->row()->value;

        $query = $this->db->get_where($account_type, array(
            $account_type . '_id' => $id
        ));
        if ($query->num_rows() > 0) {
            $email_msg = "Your account type is : " . $account_type . "<br />";
            if ($query->row()->status == 'approved') {
                $email_msg .= "Your account is : Approved<br />";
            } else {
                $email_msg .= "Your account is : Postponed<br />";
            }
            $email_sub = "Account Status Change";
            $from = $system_email;
            $from_name = $system_name;
            $email_to = $query->row()->email;
            $this->do_email($email_msg, $email_sub, $email_to, $from);
            return true;
        } else {
            return false;
        }
    }


    function membership_upgrade_email($vendor)
    {
        $this->load->database();
        $account_type = 'vendor';
        $system_name = $this->db->get_where('general_settings', array(
            'type' => 'system_name'
        ))->row()->value;
        $system_email = $this->db->get_where('general_settings', array(
            'type' => 'system_email'
        ))->row()->value;

        $query = $this->db->get_where($account_type, array(
            $account_type . '_id' => $id
        ));
        if ($query->num_rows() > 0) {
            if ($query->row()->membership == '0') {
                $email_msg = "Your Membership Type is reduced to : Default <br />";
            } else {
                $email_msg = "Your Membership Type is upgraded to : " . $this->db->get_where('membership', array('membership_id' => $query->row()->membership))->row()->title . "<br />";
            }
            $email_sub = "Membership Upgrade";
            $from = $system_email;
            $from_name = $system_name;
            $email_to = $query->row()->email;
            $this->do_email($email_msg, $email_sub, $email_to, $from);
            return true;
        } else {
            return false;
        }
    }

    function account_opening($account_type = '', $email = '', $pass = '')
    {
        $this->load->database();
        $system_name = $this->db->get_where('general_settings', array(
            'type' => 'system_name'
        ))->row()->value;
        $system_email = $this->db->get_where('general_settings', array(
            'type' => 'system_email'
        ))->row()->value;

        $query = $this->db->get_where($account_type, array(
            'email' => $email
        ));
        if ($query->num_rows() > 0) {
            $password = $pass;
            $email_msg = "Thanks for your registration in : " . $system_name . "<br />";
            $email_msg .= "Your account type is : " . $account_type . "<br />";
            $email_msg .= "Your password is : " . $password . "<br />";
            if ($account_type == 'vendor') {
                $email_msg .= "login here: <a href='" . base_url() . "index.php/vendor/'>" . base_url() . "index.php/vendor</a>";
                $email_msg .= "<br>Your account is now being reviewed. Please wait for Admin approval.";
            }
            if ($account_type == 'user') {

            }
            if ($account_type == 'admin') {
                $email_msg .= "login here: <a href='" . base_url() . "index.php/admin/'>" . base_url() . "index.php/admin</a>";
            }
            $email_sub = "Account Opening";
            if ($account_type == 'admin') {
                $to_name = $query->row()->name;
            } elseif ($account_type == 'user') {
                $to_name = $query->row()->username;
            } elseif ($account_type == 'user') {
                $to_name = $query->row()->dispaly_name;
            }
            $from = $system_email;
            $from_name = $system_name;
            $email_to = $email;

            $this->do_email($email_msg, $email_sub, $email_to, $from);
            return true;
        } else {
            return false;
        }
    }

    function send_email($email = '',$email_sub = '',$email_msg = ''){
        $this->load->database();
            $system_email = $this->db->get_where('general_settings', array(
                'type' => 'system_email'
            ))->row()->value;
            $from = $system_email;
            $email_to = $email;
        $this->do_email($email_msg, $email_sub, $email_to, $from);
        return true;
    }

    function account_confirm($account_type = '', $email = '', $pass = '', $active = '')
    {
        $this->load->database();
        $system_name = $this->db->get_where('general_settings', array(
            'type' => 'system_name'
        ))->row()->value;
        $system_email = $this->db->get_where('general_settings', array(
            'type' => 'system_email'
        ))->row()->value;

        $query = $this->db->get_where($account_type, array(
            'email' => $email
        ));
        if ($query->num_rows() > 0) {
            $password = $pass;
            $email_msg = '
            <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
            <tbody><tr><td valign="top" bgcolor="#FFFFFF" width="100%">         
            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
            <tbody><tr>
            <td width="100%"><table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tbody><tr>
            <td>
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px" align="center">
            <tbody><tr><td style="padding:0;color:#000000;text-align:left" bgcolor="#FFFFFF" width="100%" align="left">
            <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="display:none!important;opacity:0;color:transparent;height:0;width:0">
            <tbody><tr><td><p></p></td></tr>
            </tbody></table>
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
            <tbody><tr>
            <td style="font-size:6px;line-height:10px;background-color:#ffffff;padding:0" valign="top" align="">
            <img width="600" height="50" src="' . base_url() . 'template/front/assets/img/tabmail.png" alt="" border="0" style="display:block;color:#000;text-decoration:none;font-family:Helvetica,arial,sans-serif;font-size:16px">
            </td>
            </tr>
            </tbody></table><table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
            <tbody><tr>
            <td valign="top" height="100%" style="padding:10px 30px 10px 30px" bgcolor="#ffffff"><p>&nbsp;</p>  <p><span style="font-size:14px"><span style="color:#808080"><span>ยินดีต้อนรับ&nbsp;'.$query->row()->username.',</span></span></span></p>  <p>&nbsp;</p>  <p><span style="font-size:14px"><span style="color:#808080"><span>ก่อนเริ่มต้นใช้งาน&nbsp;กรุณายืนยัน <a href="mailto:' . $email . '" target="_blank">' . $email . '</a> ของคุณด้านล่าง</span></span></span></p> </td>
            </tr>
            </tbody></table>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
            <tbody><tr>
            <td style="padding:10px 30px 10px 30px" align="left" bgcolor="#ffffff">
            <table border="0" cellpadding="0" cellspacing="0">
            <tbody><tr>
            <td align="center" style="border-radius:6px;font-size:16px" bgcolor="#FEBF32">
            <a href="' . base_url() . 'index.php/home/registration/account_confirm/' . $active . '" style="height:px;width:250px;font-size:16px;line-height:px;font-family:Helvetica,Arial,sans-serif;color:#ffffff;padding:12px 18px 12px 18px;text-decoration:none;color:#ffffff;text-decoration:none;border-radius:6px;border:1px solid #FEBF32;display:inline-block" target="_blank">
            ยืนยันอีเมลของคุณ
            </a>
            </td>
            </tr>
            </tbody></table>
            </td>
            </tr>
            </tbody></table>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
            <tbody><tr>
            <td valign="top" height="100%" style="padding:10px 30px 10px 30px" bgcolor="#ffffff"><p><span style="font-size:14px"><span style="color:#808080">ขอบคุณสำหรับการยืนยันอีเมล!</span></span></p>  <p><font color="#808080"><span style="font-size:14px">ทีมงาน HeelCare Thailand</span></font></p> </td>
            </tr>
            </tbody></table>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
            <tbody><tr><td style="padding:0 0 30px 0" bgcolor="#ffffff"></td></tr></tbody></table>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
            <tbody><tr>
            <td valign="top" height="100%" style="padding:0 30px 0 30px" bgcolor="#ffffff"><div> <div style="font-style:normal;font-variant:normal;font-weight:normal;font-size:14px;line-height:14px;font-family:arial,sans-serif;color:rgb(0,0,0);background-color:rgb(255,255,255)"><span style="color:rgb(169,169,169)"><span style="font-size:11px">Button not working?</span></span>&nbsp;<span style="color:rgb(169,169,169)"><span style="font-size:11px">please copy and paste this&nbsp;<u><a href="' . base_url() . 'index.php/home/registration/account_confirm/' . $active . '" target="_blank">' . base_url() . 'index.php/home/registration/account_confirm/' . $active . '</a></u><wbr>&nbsp;into a new browser window.</span></span></div>  <div style="font-style:normal;font-variant:normal;font-weight:normal;font-size:14px;line-height:14px;font-family:arial,sans-serif;color:rgb(0,0,0);background-color:rgb(255,255,255)">&nbsp;</div>  <div style="font-style:normal;font-variant:normal;font-weight:normal;font-size:14px;line-height:14px;font-family:arial,sans-serif;color:rgb(0,0,0);background-color:rgb(255,255,255)"><span style="color:rgb(169,169,169)"><span style="font-size:11px">You’re receiving this email because you have linked this&nbsp;email address to HeelCare Thailand profile. If this wasn’t you, please ignore this email.</span></span></div> </div> </td>
            </tr>
            </tbody></table>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
            <tbody><tr><td style="padding:0 0 30px 0" bgcolor="#ffffff"></td></tr></tbody></table>
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
            <tbody><tr>
            <td style="font-size:6px;line-height:10px;background-color:#ffffff;padding:0" valign="top" align="center">
            <a href="' . base_url() . '" target="_blank">
            <img width="150" height="" src="' . $this->crud_model->logo('home_top_logo') . '" alt="" border="0" style="display:block;color:#000;text-decoration:none;font-family:Helvetica,arial,sans-serif;font-size:16px;max-width:150px!important;width:100%!important;height:auto!important">
            </a>
            </td>
            </tr>
            </tbody></table><table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
            <tbody><tr><td style="padding:0 0 5px 0" bgcolor="#ffffff"></td></tr></tbody></table>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
            <tbody><tr>
            <td valign="top" height="100%" style="padding:0" bgcolor="#ffffff"><div> <div style="text-align:center"> <p style="font-style:normal;font-variant:normal;font-weight:normal;font-size:14px;line-height:14px;font-family:arial,sans-serif;color:rgb(0,0,0);text-align:center;background-color:rgb(255,255,255)"><strong><span style="font-size:10px"><span style="color:rgb(169,169,169)">SpaFoods</span></span></strong></p>  <p style="font-style:normal;font-variant:normal;font-weight:normal;font-size:14px;line-height:14px;font-family:arial,sans-serif;color:rgb(0,0,0);text-align:center;background-color:rgb(255,255,255)"><span style="font-size:10px"><span style="color:rgb(169,169,169)">© 2017 SpaFoods, All rights reserved.</span></span></p>  <p style="font-style:normal;font-variant:normal;font-weight:normal;font-size:14px;line-height:14px;font-family:arial,sans-serif;color:rgb(0,0,0);text-align:center;background-color:rgb(255,255,255)"><span style="font-size:10px"><span style="color:rgb(169,169,169)">611/277 - 279 Soi Watchannai (Rajuthit), Bangklo</span></span></p>  <p style="font-style:normal;font-variant:normal;font-weight:normal;font-size:14px;line-height:14px;font-family:arial,sans-serif;color:rgb(0,0,0);text-align:center;background-color:rgb(255,255,255)"><span style="font-size:10px"><span style="color:rgb(169,169,169)">Bangkholeam, Bangkok 10120. Thailand</span></span></p>  <p style="font-style:normal;font-variant:normal;font-weight:normal;font-size:14px;line-height:14px;font-family:arial,sans-serif;color:rgb(0,0,0);text-align:center;background-color:rgb(255,255,255)"><span style="font-style:normal;font-variant:normal;font-weight:normal;font-size:10px;line-height:10px;font-family:arial,sans-serif;color:rgb(169,169,169)">Reach out to our team:&nbsp;</span><a href="mailto:spafoodsofficial@gmail.com" style="font-style:normal;font-variant:normal;font-weight:normal;font-size:10px;line-height:10px;font-family:arial,sans-serif;background-color:rgb(255,255,255)" target="_blank"><span style="color:rgb(0,153,204)">spafoodsofficial@gmail.com</span></a></p> </div> </div> </td>
            </tr>
            </tbody></table>
            <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
            <tbody><tr><td style="padding:10px 5px 10px 5px" bgcolor="#ffffff">
            <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
            <tbody><tr>
            <td align="center" valign="top" width="100%" height="100%">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
            <tbody><tr>
            <td height="100%" style="height:100%">
            
            </td>
            </tr>
            </tbody></table>
            </td>
            </tr>
            </tbody></table>
            </td></tr>
            </tbody></table>
            </td></tr></tbody></table></td>
            </tr></tbody></table>
            </td>
            </tr>
            </tbody></table></td>
            </tr>
            </tbody></table>';
            $email_sub = "กรุณายืนยันอีเมลของคุณ - SpaFoods";
            if ($account_type == 'admin') {
                $to_name = $query->row()->name;
            } elseif ($account_type == 'user') {
                $to_name = $query->row()->username;
            } elseif ($account_type == 'user') {
                $to_name = $query->row()->dispaly_name;
            }
            $from = $system_email;
            $from_name = $system_name;
            $email_to = $email;

            $this->do_email($email_msg, $email_sub, $email_to, $from);
            return true;
        } else {
            return false;
        }
    }


    function newsletter($title = '', $text = '', $email = '', $from = '')
    {
        $this->do_email($text, $title, $email, $from);
    }


    /***custom email sender****/

    function do_email($msg = NULL, $sub = NULL, $to = NULL, $from = NULL)
    {
        $this->load->database();
        $system_name = $this->db->get_where('general_settings', array(
            'type' => 'system_name'
        ))->row()->value;
        if ($from == NULL)
            $from = $this->db->get_where('general_settings', array(
                'type' => 'system_email'
            ))->row()->value;

        $this->email
            ->from($from)
            ->reply_to($from)// Optional, an account where a human being reads.
            ->to($to)
            ->subject($sub)
            ->message($msg)
            ->send();

//        var_dump($result);
//        echo '<br />';
//        echo $this->email->print_debugger();

    }


}