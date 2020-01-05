<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Admin extends CI_Controller
{
    /*  
     *  Developed by: Active IT zone
     *  Date    : 14 July, 2015
     *  Active Supershop eCommerce CMS
     *  http://codecanyon.net/user/activeitezone
     */
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('paypal');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->crud_model->ip_data();
    }
    
    /* index of the admin. Default: Dashboard; On No Login Session: Back to login page. */
    public function index()
    {
        if ($this->session->userdata('admin_login') == 'yes') {
            $page_data['page_name'] = "dashboard";
            $this->load->view('back/index', $page_data);
        } else {
            $page_data['control'] = "admin";
            $this->load->view('back/login',$page_data);
        }
    }


    /* Manage Gallery */
    function gallery($para1 = "")
    {
        if (!$this->crud_model->admin_permission('gallery')) {
            redirect(base_url() . 'index.php/admin');
        }
        $page_data['page_name'] = "gallery";
        $page_data['para1']  = $para1;
        $this->load->view('back/index', $page_data);
    }


    /* Manage Logos */
    function upload_gallery($para1 = "", $para2 = "", $para3 = "")
    {
        if (!$this->crud_model->admin_permission('gallery')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "delete_gallery") {
            $page_data = $this->db->get_where('gallery', array(
                'gallery_id' => $para2
            ))->result_array();
            foreach ($page_data as $row){
                if (file_exists("uploads/gallery_image/".$row['gallery_name'].$row['gallery_extension'])) {
                    unlink("uploads/gallery_image/".$row['gallery_name'].$row['gallery_extension']);
                    unlink("uploads/gallery_image/".$row['gallery_name']."_thumb".$row['gallery_extension']);
                }
            }
            $this->db->where('gallery_id', $para2);
            $this->db->delete('gallery');
        } elseif ($para1 == "show_all") {
//                $page_data['gallery'] = $this->db->get('gallery')->result_array();
                $page_data['gallery'] = $this->db->get_where('gallery', array(
                    'c_gallery_id' => $para2
                ))->result_array();
                $this->load->view('back/admin/all_gallery', $page_data);

        }elseif ($para1 == "upload_gallery") {
            foreach ($_FILES["file"]['name'] as $i => $row) {
                $ext = ".".pathinfo($_FILES["file"]['name'][$i], PATHINFO_EXTENSION);
                $filename = pathinfo($_FILES["file"]['name'][$i], PATHINFO_FILENAME);
                $time = date("d-m-Y")."-".time() ;
                $filename_real = $time."-".$filename;
                $data['c_gallery_id'] = $para2;
                $data['create_date'] = date("Y-m-d H:i:s");
                $data['gallery_name'] = $filename_real;
                $data['gallery_extension'] = $ext;
                $this->db->insert('gallery', $data);
                $this->crud_model->file_up_gallery($_FILES["file"]['tmp_name'][$i], "gallery", $filename_real,$ext);
            }

            return;
        } else {
            $this->load->view('back/index', $page_data);
        }
    }

    /*Gallery Category*/
    function gallery_category($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('gallery_category')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['c_gallery_title'] = $this->input->post('c_gallery_title');
            $data['c_gallery_description'] = $this->input->post('c_gallery_description');
            $data['create_by']   = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['create_date'] = date("Y-m-d H:i:s");
            $this->db->insert('gallery_category', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("images", "gallery_category", $id, '');
        } else if ($para1 == 'edit') {
            $page_data['category_data'] = $this->db->get_where('gallery_category', array(
                'c_gallery_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/gallery_category_edit', $page_data);
        } elseif ($para1 == "update") {

            $data['c_gallery_title'] = $this->input->post('c_gallery_title');
            $data['c_gallery_description'] = $this->input->post('c_gallery_description');
            $data['update_by']           = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['update_date'] = date("Y-m-d H:i:s");
            $this->crud_model->file_up("images", "gallery_category", $para2, '');
            $this->db->where('c_gallery_id', $para2);
            $this->db->update('gallery_category', $data);

        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('gallery_category', $para2, '.jpg', '');
            $this->db->where('c_gallery_id', $para2);
            $this->db->delete('gallery_category');
        } elseif ($para1 == 'list') {
            $this->db->order_by('c_gallery_id', 'desc');
            $page_data['all_categories'] = $this->db->get('gallery_category')->result_array();
            $this->load->view('back/admin/gallery_category_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/gallery_category_add');
        } else {
            $page_data['page_name']      = "gallery_category";
            $page_data['all_categories'] = $this->db->get('gallery_category')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }

    
    /*Product Category add, edit, view, delete */
    function category($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('category')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['category_name'] = $this->input->post('category_name');
            $data['category_name_en'] = $this->input->post('category_name_en');
            $this->db->insert('category', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("pic", "category", $id,''); 
        } else if ($para1 == 'edit') {
            $page_data['category_data'] = $this->db->get_where('category', array(
                'category_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/category_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['category_name'] = $this->input->post('category_name');
            $data['category_name_en'] = $this->input->post('category_name_en');
            $this->db->where('category_id', $para2);
            $this->db->update('category', $data);
            $this->crud_model->file_up("pic", "category", $para2,''); 
        } elseif ($para1 == 'delete') {
            $this->db->where('category_id', $para2);
            $this->db->delete('category');
        } elseif ($para1 == 'list') {
            $this->db->order_by('category_id', 'desc');
            $page_data['all_categories'] = $this->db->get('category')->result_array();
            $this->load->view('back/admin/category_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/category_add');
        } else {
            $page_data['page_name']      = "category";
            $page_data['all_categories'] = $this->db->get('category')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*Product Sub-category add, edit, view, delete */
    function sub_category($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('sub_category')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['sub_category_name'] = $this->input->post('sub_category_name');
            $data['sub_category_name_en'] = $this->input->post('sub_category_name_en');
            $data['description'] = $this->input->post('description');
            $data['description_en'] = $this->input->post('description_en');
            $data['category']          = $this->input->post('category');
            $this->db->insert('sub_category', $data);
        } else if ($para1 == 'edit') {
            $page_data['sub_category_data'] = $this->db->get_where('sub_category', array(
                'sub_category_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/sub_category_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['sub_category_name'] = $this->input->post('sub_category_name');
            $data['sub_category_name_en'] = $this->input->post('sub_category_name_en');
            $data['description'] = $this->input->post('description');
            $data['description_en'] = $this->input->post('description_en');
            $data['category']          = $this->input->post('category');
            $this->db->where('sub_category_id', $para2);
            $this->db->update('sub_category', $data);
            redirect(base_url() . 'index.php/admin/sub_category/', 'refresh');
        } elseif ($para1 == 'delete') {
            $this->db->where('sub_category_id', $para2);
            $this->db->delete('sub_category');
        } elseif ($para1 == 'list') {
            $this->db->order_by('sub_category_id', 'desc');
            $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();
            $this->load->view('back/admin/sub_category_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/sub_category_add');
        } else {
            $page_data['page_name']        = "sub_category";
            $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*Product Brand add, edit, view, delete */
    function brand($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('brand')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $type                = 'brand';
            $data['name']        = $this->input->post('name');
            $data['category']    = $this->input->post('category');
            $this->db->insert('brand', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("img", "brand", $id, '', '', '.png');
        } elseif ($para1 == "update") {
            $data['name']        = $this->input->post('name');
            $data['category']    = $this->input->post('category');
            $this->db->where('brand_id', $para2);
            $this->db->update('brand', $data);
            $this->crud_model->file_up("img", "brand", $para2, '', '', '.png');
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('brand', $para2, '.png');
            $this->db->where('brand_id', $para2);
            $this->db->delete('brand');
        } elseif ($para1 == 'multi_delete') {
            $ids = explode('-', $para2);
            $this->crud_model->multi_delete('brand', $ids);
        } else if ($para1 == 'edit') {
            $page_data['brand_data'] = $this->db->get_where('brand', array(
                'brand_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/brand_edit', $page_data);
        } elseif ($para1 == 'list') {
            $this->db->order_by('brand_id', 'desc');
            $page_data['all_brands'] = $this->db->get('brand')->result_array();
            $this->load->view('back/admin/brand_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/brand_add');
        } else {
            $page_data['page_name']  = "brand";
            $page_data['all_brands'] = $this->db->get('brand')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*Product coupon add, edit, view, delete */
    function coupon($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('coupon')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['title'] = $this->input->post('title');
            $data['code'] = $this->input->post('code');
            $data['till'] = $this->input->post('till');
            $data['status'] = 'ok';
            $data['added_by'] = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['spec'] = json_encode(array(
                                'set_type'=>$this->input->post('set_type'),
                                'set'=>json_encode($this->input->post($this->input->post('set_type'))),
                                'discount_type'=>$this->input->post('discount_type'),
                                'discount_value'=>$this->input->post('discount_value'),
                                'shipping_free'=>$this->input->post('shipping_free')
                            ));
            $this->db->insert('coupon', $data);
        } else if ($para1 == 'edit') {
            $page_data['coupon_data'] = $this->db->get_where('coupon', array(
                'coupon_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/coupon_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['title'] = $this->input->post('title');
            $data['code'] = $this->input->post('code');
            $data['till'] = $this->input->post('till');
            $data['spec'] = json_encode(array(
                                'set_type'=>$this->input->post('set_type'),
                                'set'=>json_encode($this->input->post($this->input->post('set_type'))),
                                'discount_type'=>$this->input->post('discount_type'),
                                'discount_value'=>$this->input->post('discount_value'),
                                'shipping_free'=>$this->input->post('shipping_free')
                            ));
            $this->db->where('coupon_id', $para2);
            $this->db->update('coupon', $data);
        } elseif ($para1 == 'delete') {
            $this->db->where('coupon_id', $para2);
            $this->db->delete('coupon');
        } elseif ($para1 == 'list') {
            $this->db->order_by('coupon_id', 'desc');
            $page_data['all_coupons'] = $this->db->get('coupon')->result_array();
            $this->load->view('back/admin/coupon_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/coupon_add');
        } elseif ($para1 == 'publish_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('coupon_id', $product);
            $this->db->update('coupon', $data);
        } else {
            $page_data['page_name']      = "coupon";
            $page_data['all_coupons'] = $this->db->get('coupon')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*Product Sale Comparison Reports*/
    function report($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('report')) {
            redirect(base_url() . 'index.php/admin');
        }
        $page_data['page_name'] = "report";
        $page_data['products']  = $this->db->get('product')->result_array();
        $this->load->view('back/index', $page_data);
    }
    
    /*Product Stock Comparison Reports*/
    function report_stock($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('report')) {
            redirect(base_url() . 'index.php/admin');
        }
        $page_data['page_name'] = "report_stock";
        if ($this->input->post('product')) {
            $page_data['product_name'] = $this->crud_model->get_type_name_by_id('product', $this->input->post('product'), 'title');
            $page_data['product']      = $this->input->post('product');
        }
        $this->load->view('back/index', $page_data);
    }
    
    /*Product Wish Comparison Reports*/
    function report_wish($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('report')) {
            redirect(base_url() . 'index.php/admin');
        }
        $page_data['page_name'] = "report_wish";
        $this->load->view('back/index', $page_data);
    }
    
    /* Product add, edit, view, delete, stock increase, decrease, discount */
    function product($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('product')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $options = array();
            if ($_FILES["images"]['name'][0] == '') {
                $num_of_imgs = 0;
            } else {
                $num_of_imgs = count($_FILES["images"]['name']);
            }
            $data['title']              = $this->input->post('title');
            $data['title_en']           = $this->input->post('title_en');
            $data['category']           = $this->input->post('category');
            $data['description']        = $this->input->post('description');
            $data['description_en']     = $this->input->post('description_en');
            $data['sub_category']       = $this->input->post('sub_category');
            $data['sale_price']         = $this->input->post('sale_price');
            $data['purchase_price']     = $this->input->post('purchase_price');
            $data['add_timestamp']      = time();
            $data['featured']           = '0';
            $data['status']             = 'ok';
            $data['rating_user']        = '[]';
            $data['tax']                = $this->input->post('tax');
            $data['discount']           = $this->input->post('discount');
            $data['discount_type']      = $this->input->post('discount_type');
            $data['tax_type']           = $this->input->post('tax_type');
            $data['shipping_cost']      = $this->input->post('shipping_cost');
            $data['tag']                = $this->input->post('tag');
            $data['color']              = json_encode($this->input->post('color'));
            $data['num_of_imgs']        = $num_of_imgs;
            $data['current_stock']      = $this->input->post('current_stock');
            $data['front_image']        = $this->input->post('front_image');
            $additional_fields['name']  = json_encode($this->input->post('ad_field_names'));
            $additional_fields['value'] = json_encode($this->input->post('ad_field_values'));
            $data['additional_fields']  = json_encode($additional_fields);
            $data['brand']              = $this->input->post('brand');
            $data['unit']               = $this->input->post('unit');
            $choice_titles              = $this->input->post('op_title');
            $choice_types               = $this->input->post('op_type');
            $choice_no                  = $this->input->post('op_no');
			$data['added_by']           = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
			if(count($choice_titles ) > 0){
				foreach ($choice_titles as $i => $row) {
					$choice_options         = $this->input->post('op_set'.$choice_no[$i]);
					$options[]              =   array(
													'no' => $choice_no[$i],
													'title' => $choice_titles[$i],
													'name' => 'choice_'.$choice_no[$i],
													'type' => $choice_types[$i],
													'option' => $choice_options
												);
				}
			}
            $data['options']            = json_encode($options);
            $this->db->insert('product', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("images", "product", $id, 'multi');
        } else if ($para1 == "update") {
            $options = array();
            if ($_FILES["images"]['name'][0] == '') {
                $num_of_imgs = 0;
            } else {
                $num_of_imgs = count($_FILES["images"]['name']);
            }
            $num                        = $this->crud_model->get_type_name_by_id('product', $para2, 'num_of_imgs');
            $data['title']              = $this->input->post('title');
            $data['title_en']           = $this->input->post('title_en');
            $data['category']           = $this->input->post('category');
            $data['description_en']     = $this->input->post('description_en');
            $data['description']        = $this->input->post('description');
            $data['sub_category']       = $this->input->post('sub_category');
            $data['sale_price']         = $this->input->post('sale_price');
            $data['purchase_price']     = $this->input->post('purchase_price');
            $data['featured']           = $this->input->post('featured');
            $data['tax']                = $this->input->post('tax');
            $data['discount']           = $this->input->post('discount');
            $data['discount_type']      = $this->input->post('discount_type');
            $data['tax_type']           = $this->input->post('tax_type');
            $data['shipping_cost']      = $this->input->post('shipping_cost');
            $data['tag']                = $this->input->post('tag');
            $data['color']              = json_encode($this->input->post('color'));
            $data['num_of_imgs']        = $num + $num_of_imgs;
            $data['front_image']        = $this->input->post('front_image');
            $additional_fields['name']  = json_encode($this->input->post('ad_field_names'));
            $additional_fields['value'] = json_encode($this->input->post('ad_field_values'));
            $data['additional_fields']  = json_encode($additional_fields);
            $data['brand']              = $this->input->post('brand');
            $data['unit']               = $this->input->post('unit');
            $choice_titles              = $this->input->post('op_title');
            $choice_types               = $this->input->post('op_type');
            $choice_no                  = $this->input->post('op_no');
			if(count($choice_titles ) > 0){
				foreach ($choice_titles as $i => $row) {
					$choice_options         = $this->input->post('op_set'.$choice_no[$i]);
					$options[]              =   array(
													'no' => $choice_no[$i],
													'title' => $choice_titles[$i],
													'name' => 'choice_'.$choice_no[$i],
													'type' => $choice_types[$i],
													'option' => $choice_options
												);
				}
			}
            $data['options']            = json_encode($options);
            $this->crud_model->file_up("images", "product", $para2, 'multi');
            $this->db->where('product_id', $para2);
            $this->db->update('product', $data);
        } else if ($para1 == 'edit') {
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/product_edit', $page_data);
        } else if ($para1 == 'view') {
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/product_view', $page_data);
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('product', $para2, '.jpg', 'multi');
            $this->db->where('product_id', $para2);
            $this->db->delete('product');
        } elseif ($para1 == 'list') {
            $this->db->order_by('product_id', 'desc');
            $page_data['all_product'] = $this->db->get('product')->result_array();
            $this->load->view('back/admin/product_list', $page_data);
        } else if ($para1 == 'dlt_img') {
            $a = explode('_', $para2);
            $this->crud_model->file_dlt('product', $a[0], '.jpg', 'multi', $a[1]);
        } elseif ($para1 == 'sub_by_cat') {
            echo $this->crud_model->select_html('sub_category', 'sub_category', 'sub_category_name', 'add', 'demo-chosen-select required', '', 'category', $para2, 'get_sub_res');
        } elseif ($para1 == 'brand_by_cat') {
            echo $this->crud_model->select_html('brand', 'brand', 'name', 'add', 'demo-chosen-select', '', 'category', $para2, '');
        } elseif ($para1 == 'product_by_sub') {
            echo $this->crud_model->select_html('product', 'product', 'title', 'add', 'demo-chosen-select required', '', 'sub_category', $para2, 'get_pro_res');
        } elseif ($para1 == 'pur_by_pro') {
            echo $this->crud_model->get_type_name_by_id('product', $para2, 'purchase_price');
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/product_add');
        } elseif ($para1 == 'add_stock') {
            $data['product'] = $para2;
            $this->load->view('back/admin/product_stock_add', $data);
        } elseif ($para1 == 'destroy_stock') {
            $data['product'] = $para2;
            $this->load->view('back/admin/product_stock_destroy', $data);
        } elseif ($para1 == 'stock_report') {
            $data['product'] = $para2;
            $this->load->view('back/admin/product_stock_report', $data);
        } elseif ($para1 == 'sale_report') {
            $data['product'] = $para2;
            $this->load->view('back/admin/product_sale_report', $data);
        } elseif ($para1 == 'add_discount') {
            $data['product'] = $para2;
            $this->load->view('back/admin/product_add_discount', $data);
        } elseif ($para1 == 'product_featured_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['featured'] = 'ok';
            } else {
                $data['featured'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
        } elseif ($para1 == 'product_publish_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
        }elseif ($para1 == 'product_promotion_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['promotion'] = 'ok';
            } else {
                $data['promotion'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
        } elseif ($para1 == 'add_discount_set') {
            $product               = $this->input->post('product');
            $data['discount']      = $this->input->post('discount');
            $data['discount_type'] = $this->input->post('discount_type');
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
        } else {
            $page_data['page_name']   = "product";
            $page_data['all_product'] = $this->db->get('product')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Product Stock add, edit, view, delete, stock increase, decrease, discount */
    function stock($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('stock')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['type']         = 'add';
            $data['category']     = $this->input->post('category');
            $data['sub_category'] = $this->input->post('sub_category');
            $data['product']      = $this->input->post('product');
            $data['quantity']     = $this->input->post('quantity');
            $data['rate']         = $this->input->post('rate');
            $data['total']        = $this->input->post('total');
            $data['reason_note']  = $this->input->post('reason_note');
            $data['datetime']     = time();
            $this->db->insert('stock', $data);
            $prev_quantity          = $this->crud_model->get_type_name_by_id('product', $data['product'], 'current_stock');
            $data1['current_stock'] = $prev_quantity + $data['quantity'];
            $this->db->where('product_id', $data['product']);
            $this->db->update('product', $data1);
        } else if ($para1 == 'do_destroy') {
            $data['type']         = 'destroy';
            $data['category']     = $this->input->post('category');
            $data['sub_category'] = $this->input->post('sub_category');
            $data['product']      = $this->input->post('product');
            $data['quantity']     = $this->input->post('quantity');
            $data['total']        = $this->input->post('total');
            $data['reason_note']  = $this->input->post('reason_note');
            $data['datetime']     = time();
            $this->db->insert('stock', $data);
            $prev_quantity = $this->crud_model->get_type_name_by_id('product', $data['product'], 'current_stock');
            $current       = $prev_quantity - $data['quantity'];
            if ($current <= 0) {
                $current = 0;
            }
            $data1['current_stock'] = $current;
            $this->db->where('product_id', $data['product']);
            $this->db->update('product', $data1);
        } elseif ($para1 == 'delete') {
            $quantity = $this->crud_model->get_type_name_by_id('stock', $para2, 'quantity');
            $product  = $this->crud_model->get_type_name_by_id('stock', $para2, 'product');
            $type     = $this->crud_model->get_type_name_by_id('stock', $para2, 'type');
            if ($type == 'add') {
                $this->crud_model->decrease_quantity($product, $quantity);
            } else if ($type == 'destroy') {
                $this->crud_model->increase_quantity($product, $quantity);
            }
            $this->db->where('stock_id', $para2);
            $this->db->delete('stock');
        } elseif ($para1 == 'list') {
            $this->db->order_by('stock_id', 'desc');
            $page_data['all_stock'] = $this->db->get('stock')->result_array();
            $this->load->view('back/admin/stock_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/stock_add');
        } elseif ($para1 == 'destroy') {
            $this->load->view('back/admin/stock_destroy');
        } else {
            $page_data['page_name'] = "stock";
            $page_data['all_stock'] = $this->db->get('stock')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*Frontend Banner Management */
    function banner($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('banner')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "set") {
            $data['link']   = $this->input->post('link');
            $data['status'] = $this->input->post('status');
            $this->db->where('banner_id', $para2);
            $this->db->update('banner', $data);
            $this->crud_model->file_up("img", "banner", $para2);
        } else if ($para1 == 'banner_publish_set') {
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else if ($para3 == 'false') {
                $data['status'] = '0';
            }
            $this->db->where('banner_id', $para2);
            $this->db->update('banner', $data);
        } else {
            $page_data['page_name']      = "banner";
            $page_data['all_categories'] = $this->db->get('category')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Managing sales by users */
    function sales($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('sale')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'delete') {
            $carted = $this->db->get_where('stock', array(
                'sale_id' => $para2
            ))->result_array();
            foreach ($carted as $row2) {
                $this->stock('delete', $row2['stock_id']);
            }
            $this->db->where('sale_id', $para2);
            $this->db->delete('sale');
        } elseif ($para1 == 'list') {
            $all = $this->db->get_where('sale',array('payment_type' => 'go'))->result_array();
            foreach ($all as $row) {
                if((time()-$row['sale_datetime']) > 600){
                    $this->db->where('sale_id', $row['sale_id']);
                    $this->db->delete('sale');
                }
            }
            $this->db->order_by('sale_id', 'desc');
            $page_data['all_sales'] = $this->db->get('sale')->result_array();
            $this->load->view('back/admin/sales_list', $page_data);
        } elseif ($para1 == 'view') {
            $data['viewed'] = 'ok';
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
            $page_data['sale'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/sales_view', $page_data);
        } elseif ($para1 == 'send_invoice') {
            $page_data['sale'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->result_array();
            $text              = $this->load->view('back/includes_top', $page_data);
            $text .= $this->load->view('back/admin/sales_view', $page_data);
            $text .= $this->load->view('back/includes_bottom', $page_data);
        } elseif ($para1 == 'delivery_payment') {
            $data['viewed'] = 'ok';
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
            $page_data['sale_id'] = $para2;
            $page_data['payment_type'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_type;
            $page_data['payment_details'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_details;
            $delivery_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->delivery_status,true);
            foreach ($delivery_status as $row) {
                if(isset($row['admin'])){
                    $page_data['delivery_status'] = $row['status'];
                }
            }
            $payment_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_status,true);
            foreach ($payment_status as $row) {
                if(isset($row['admin'])){
                    $page_data['payment_status'] = $row['status'];
                }
            }
            
            $this->load->view('back/admin/sales_delivery_payment', $page_data);
        } elseif ($para1 == 'delivery_payment_set') {
            $delivery_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->delivery_status,true);
            $new_delivery_status = array();
            foreach ($delivery_status as $row) {
                if(isset($row['admin'])){
                    $new_delivery_status[] = array('admin'=>'','status'=>$this->input->post('delivery_status'),'delivery_time'=>$row['delivery_time']);
                } else {
                    $new_delivery_status[] = array('vendor'=>$row['vendor'],'status'=>$row['status'],'delivery_time'=>$row['delivery_time']);
                }
            }
            $payment_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_status,true);
            $new_payment_status = array();
            foreach ($payment_status as $row) {
                if(isset($row['admin'])) {
                    $new_payment_status[] = array('admin'=>'','status'=>$this->input->post('payment_status'));
                } else {
                    $new_payment_status[] = array('vendor'=>$row['vendor'],'status'=>$row['status']);
                }
            }
            $data['payment_status']  = json_encode($new_payment_status);
            $data['delivery_status'] = json_encode($new_delivery_status);
            $data['payment_details'] = $this->input->post('payment_details');
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/sales_add');
        } elseif ($para1 == 'total') {
            echo $this->db->get('sale')->num_rows();
        }elseif ($para1 == "delivery") {
            $data['viewed'] = 'ok';
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
            $page_data['sale_id'] = $para2;
            $page_data['sale'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row();
            $page_data['delivery'] = $this->db->get_where('notification_delivery', array(
                'order_id' => $page_data['sale']->sale_code
            ))->row();
            $this->load->view('back/admin/sales_delivery', $page_data);
        }elseif ($para1 == 'delivery_set') {
            $data['order_id'] = $this->input->post('order_id');
            $data['reciever'] = $this->input->post('reciever');
            $data['email'] = $this->input->post('email');
            $data['ems_code'] = $this->input->post('ems_code');
            $data['detail'] = $this->input->post('detail');
            $data['create_date'] = date("Y-m-d H:i:s");
            $data['status'] = "shipped";
            $email_msg = '
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
            <th>Order ID</th>
            <td>' . $data['order_id'] . '</td>
            </tr>
            <tr>
            <th>ชื่อ-นามสกุลผู้รับ</th>
            <td>' . $data['reciever'] . '</td>
            </tr>
            <tr>
            <th>E-mail</th>
            <td>' . $data['email'] . '</td>
            </tr>
            <tr>
            <th>EMS CODE</th>
            <td>' . $data['ems_code'] . '</td>
            </tr>
            </table>
            <br>
            <br>
            ';
            $email_msg .= $data['detail'];
            $email_msg .= '<div>'.$this->crud_model->get_type_name_by_id('general_settings','61','value').'</div>';

            $this->db->insert('notification_delivery', $data);
            $email_sub = 'หมายเลขการจัดส่งสินค้า(EMS) - Spafoods';
            $this->email_model->send_email($data['email'],$email_sub,$email_msg);
        } else {
            $page_data['page_name'] = "sales";
            $page_data['all_categories'] = $this->db->get('sale')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }



    function confirm_payment($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('manege_confirm_payment')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'delete') {
            $data['active'] = 0;
            $this->db->where('id', $para2);
            $this->db->update('confirm_payment', $data);
        } elseif ($para1 == 'list') {
            $this->db->order_by('create_date', 'desc');
            $page_data['all_confirm_payment'] = $this->db->get_where('confirm_payment',array('active' => 1))->result_array();
            $this->load->view('back/admin/confirm_payment_list', $page_data);
        } elseif ($para1 == 'view') {
            $page_data['sale'] = $this->db->get_where('sale', array(
                'sale_code' => $para2
            ))->result_array();
            $this->load->view('back/admin/confirm_payment_view', $page_data);
        } elseif ($para1 == 'send_invoice') {
            $page_data['confirm_payment'] = $this->db->get_where('sale', array(
                'sale_code' => $para2
            ))->result_array();
            $text  = $this->load->view('back/includes_top', $page_data);
            $text .= $this->load->view('back/admin/confirm_payment_view', $page_data);
            $text .= $this->load->view('back/includes_bottom', $page_data);
        } elseif ($para1 == 'approve') {
            $page_data['confirm_payment'] = $this->db->get_where('confirm_payment',array('active' => 1,'order_id' => $para2))->row();
            $page_data['order_id'] = $para2;
            $this->load->view('back/admin/confirm_payment_approve', $page_data);
        } elseif ($para1 == 'confirm_payment_set') {
            $data['status'] = $this->input->post('status');
            $this->db->where('order_id', $para2);
            $this->db->update('confirm_payment', $data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/confirm_payment_add');
        } elseif ($para1 == 'total') {
            echo $this->db->get('confirm_payment')->num_rows();
        } else {
            $page_data['page_name']      = "confirm_payment";
            $this->load->view('back/index', $page_data);
        }
    }


    /*User Management */
    function user($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('user')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['username']    = $this->input->post('user_name');
            $data['description'] = $this->input->post('description');
            $this->db->insert('user', $data);
        } else if ($para1 == 'edit') {
            $page_data['user_data'] = $this->db->get_where('user', array(
                'user_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/user_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['username']    = $this->input->post('username');
            $data['description'] = $this->input->post('description');
            $this->db->where('user_id', $para2);
            $this->db->update('user', $data);
        } elseif ($para1 == 'delete') {
            $this->db->where('user_id', $para2);
            $this->db->delete('user');
        } elseif ($para1 == 'list') {
            $this->db->order_by('user_id', 'desc');
            $page_data['all_users'] = $this->db->get('user')->result_array();
            $this->load->view('back/admin/user_list', $page_data);
        } elseif ($para1 == 'view') {
            $page_data['user_data'] = $this->db->get_where('user', array(
                'user_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/user_view', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/user_add');
        } else {
            $page_data['page_name'] = "user";
            $page_data['all_users'] = $this->db->get('user')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* membership_payment Management */
    function membership_payment($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('membership_payment')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'delete') {
            $this->db->where('membership_payment_id', $para2);
            $this->db->delete('membership_payment');
        } else if ($para1 == 'list') {
            $this->db->order_by('membership_payment_id', 'desc');
            $page_data['all_membership_payments'] = $this->db->get('membership_payment')->result_array();
            $this->load->view('back/admin/membership_payment_list', $page_data);
        } else if ($para1 == 'view') {
            $page_data['membership_payment_data'] = $this->db->get_where('membership_payment', array(
                'membership_payment_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/membership_payment_view', $page_data);
        } elseif ($para1 == 'upgrade') {
            if($this->input->post('status')){
                $membership = $this->db->get_where('membership_payment',array('membership_payment_id'=>$para2))->row()->membership;
                $vendor = $this->db->get_where('membership_payment',array('membership_payment_id'=>$para2))->row()->vendor;
                $data['status'] = $this->input->post('status');
                $data['details'] = $this->input->post('details');
                if($data['status'] == 'paid'){
                    $this->crud_model->upgrade_membership($vendor,$membership);
                }
                
                $this->db->where('membership_payment_id', $para2);
                $this->db->update('membership_payment', $data);
            }
        } else {
            $page_data['page_name'] = "membership_payment";
            $page_data['all_membership_payments'] = $this->db->get('membership_payment')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }

    /* Vendor Management */
    function vendor($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('vendor')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'delete') {
            $this->db->where('vendor_id', $para2);
            $this->db->delete('vendor');
        } else if ($para1 == 'list') {
            $this->db->order_by('vendor_id', 'desc');
            $page_data['all_vendors'] = $this->db->get('vendor')->result_array();
            $this->load->view('back/admin/vendor_list', $page_data);
        } else if ($para1 == 'view') {
            $page_data['vendor_data'] = $this->db->get_where('vendor', array(
                'vendor_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/vendor_view', $page_data);
        } else if ($para1 == 'pay_form') {
            $page_data['vendor_id'] = $para2;
            $this->load->view('back/admin/vendor_pay_form', $page_data);
        } else if ($para1 == 'approval') {
            $page_data['vendor_id'] = $para2;
            $page_data['status'] = $this->db->get_where('vendor', array(
											'vendor_id' => $para2
										))->row()->status;
            $this->load->view('back/admin/vendor_approval', $page_data);
        } else if ($para1 == 'add') {
            $this->load->view('back/admin/vendor_add');
        } else if ($para1 == 'approval_set') {
            $vendor = $para2;
			$approval = $this->input->post('approval');
            if ($approval == 'ok') {
                $data['status'] = 'approved';
            } else {
                $data['status'] = 'pending';
            }
            $this->db->where('vendor_id', $vendor);
            $this->db->update('vendor', $data);
            $this->email_model->status_email('vendor', $vendor);
        } elseif ($para1 == 'pay') {
            $vendor         = $para2;
            $method         = $this->input->post('method');
            $amount         = $this->input->post('amount');
            $amount_in_usd  = $amount/$this->db->get_where('business_settings',array('type'=>'exchange'))->row()->value;
            if ($method == 'paypal') {
                $paypal_email  = $this->crud_model->get_type_name_by_id('vendor', $vendor, 'paypal_email');
                $data['vendor_id']      = $vendor;
                $data['amount']         = $this->input->post('amount');
                $data['status']         = 'due';
                $data['method']         = 'paypal';
                $data['timestamp']      = time();

                $this->db->insert('vendor_invoice', $data);
                $invoice_id           = $this->db->insert_id();
                $this->session->set_userdata('invoice_id', $invoice_id);
                
                /****TRANSFERRING USER TO PAYPAL TERMINAL****/
                $this->paypal->add_field('rm', 2);
                $this->paypal->add_field('no_note', 0);
                $this->paypal->add_field('cmd', '_xclick');
                
                $this->paypal->add_field('amount', $this->cart->format_number($amount_in_usd));

                //$this->paypal->add_field('amount', $grand_total);
                $this->paypal->add_field('custom', $invoice_id);
                $this->paypal->add_field('business', $paypal_email);
                $this->paypal->add_field('notify_url', base_url() . 'index.php/admin/paypal_ipn');
                $this->paypal->add_field('cancel_return', base_url() . 'index.php/admin/paypal_cancel');
                $this->paypal->add_field('return', base_url() . 'index.php/admin/paypal_success');
                
                $this->paypal->submit_paypal_post();
                // submit the fields to paypal

            } else if ($method == 'stripe') {
                if($this->input->post('stripeToken')) {
                                    
                    $vendor         = $para2;
                    $method         = $this->input->post('method');
                    $amount         = $this->input->post('amount');
                    $amount_in_usd  = $amount/$this->db->get_where('business_settings',array('type'=>'exchange'))->row()->value;
                    
                    $stripe_details      = json_decode($this->db->get_where('vendor', array(
                        'vendor_id' => $vendor
                    ))->row()->stripe_details,true);
                    $stripe_publishable  = $stripe_details['publishable'];
                    $stripe_api_key      =  $stripe_details['secret'];

                    require_once(APPPATH . 'libraries/stripe-php/init.php');
                    Stripe::setApiKey($stripe_api_key); //system payment settings
                    $vendor_email = $this->db->get_where('vendor' , array('vendor_id' => $vendor))->row()->email;
                    
                    $vendora = Customer::create(array(
                        'email' => $this->db->get_where('general_settings',array('type'=>'system_email'))->row()->value, // customer email id
                        'card'  => $_POST['stripeToken']
                    ));

                    $charge = Charge::create(array(
                        'customer'  => $vendora->id,
                        'amount'    => ceil($amount_in_usd*100),
                        'currency'  => 'USD'
                    ));

                    if($charge->paid == true){
                        $vendora = (array) $vendora;
                        $charge = (array) $charge;
                        
                        $data['vendor_id']          = $vendor;
                        $data['amount']             = $amount;
                        $data['status']             = 'paid';
                        $data['method']             = 'stripe';
                        $data['timestamp']          = time();
                        $data['payment_details']    = "Customer Info: \n".json_encode($vendora,true)."\n \n Charge Info: \n".json_encode($charge,true);
                        
                        $this->db->insert('vendor_invoice', $data);
                        
                        redirect(base_url() . 'index.php/admin/vendor/', 'refresh');
                    } else {
                        $this->session->set_flashdata('alert', 'unsuccessful_stripe');
                        redirect(base_url() . 'index.php/admin/vendor/', 'refresh');
                    }
                    
                } else{
                    $this->session->set_flashdata('alert', 'unsuccessful_stripe');
                    redirect(base_url() . 'index.php/admin/vendor/', 'refresh');
                }

            } else if ($method == 'cash') {
                $data['vendor_id']          = $para2;
                $data['amount']             = $this->input->post('amount');
                $data['status']             = 'due';
                $data['method']             = 'cash';
                $data['timestamp']          = time();
                $data['payment_details']    = "";
                $this->db->insert('vendor_invoice', $data);
                redirect(base_url() . 'index.php/admin/vendor/', 'refresh');
            }
        } else {
            $page_data['page_name'] = "vendor";
            $page_data['all_vendors'] = $this->db->get('vendor')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }


    
    /* FUNCTION: Verify paypal payment by IPN*/
    function paypal_ipn()
    {
        if ($this->paypal->validate_ipn() == true) {
            
            $data['status']             = 'paid';
            $data['payment_details']    = json_encode($_POST);
            $invoice_id                 = $_POST['custom'];
            $this->db->where('vendor_invoice_id', $invoice_id);
            $this->db->update('vendor_invoice', $data);
        }
    }
    

    /* FUNCTION: Loads after cancelling paypal*/
    function paypal_cancel()
    {
        $invoice_id = $this->session->userdata('invoice_id');
        $this->db->where('vendor_invoice_id', $invoice_id);
        $this->db->delete('vendor_invoice');
        $this->session->set_userdata('vendor_invoice_id', '');
        $this->session->set_flashdata('alert', 'payment_cancel');
        redirect(base_url() . 'index.php/admin/vendor/', 'refresh');
    }
    
    /* FUNCTION: Loads after successful paypal payment*/
    function paypal_success()
    {
        $this->session->set_userdata('invoice_id', '');
        redirect(base_url() . 'index.php/admin/vendor/', 'refresh');
    }
    
    /* Membership Management */
    function membership($para1 = '', $para2 = '',$para3 = '')
    {
        if (!$this->crud_model->admin_permission('membership')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['title']    = $this->input->post('title');
            $data['price']    = $this->input->post('price');
            $data['timespan']    = $this->input->post('timespan');
            $data['product_limit']    = $this->input->post('product_limit');
            $this->db->insert('membership', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("img", "membership", $id, '', '', '.png');
        } else if ($para1 == 'edit') {
            $page_data['membership_data'] = $this->db->get_where('membership', array(
                'membership_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/membership_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['title']    = $this->input->post('title');
            $data['price']    = $this->input->post('price');
            $data['timespan']    = $this->input->post('timespan');
            $data['product_limit']    = $this->input->post('product_limit');
            $this->db->where('membership_id', $para2);
            $this->db->update('membership', $data);
            $this->crud_model->file_up("img", "membership", $para2, '', '', '.png');
        } elseif ($para1 == "default_set") {
            $this->db->where('type', "default_member_product_limit");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('product_limit')
            ));
            $this->crud_model->file_up("img", "membership", 0, '', '', '.png');
        } elseif ($para1 == 'delete') {
            $this->db->where('membership_id', $para2);
            $this->db->delete('membership');
        } elseif ($para1 == 'list') {
            $this->db->order_by('membership_id', 'desc');
            $page_data['all_memberships'] = $this->db->get('membership')->result_array();
            $this->load->view('back/admin/membership_list', $page_data);
        } elseif ($para1 == 'view') {
            $page_data['membership_data'] = $this->db->get_where('membership', array(
                'membership_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/membership_view', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/membership_add');
        } elseif ($para1 == 'default') {
            $this->load->view('back/admin/membership_default');
        } elseif ($para1 == 'publish_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'approved';
            } else {
                $data['status'] = 'pending';
            }
            $this->db->where('membership_id', $product);
            $this->db->update('membership', $data);
        } else {
            $page_data['page_name'] = "membership";
            $page_data['all_memberships'] = $this->db->get('membership')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Administrator Management */
    function admins($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('admin')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['name']      = $this->input->post('name');
            $data['email']     = $this->input->post('email');
            $data['phone']     = $this->input->post('phone');
            $data['address']   = $this->input->post('address');
            $password          = substr(hash('sha512', rand()), 0, 12);
            $data['password']  = sha1($password);
            $data['role']      = $this->input->post('role');
            $data['timestamp'] = time();
            $this->db->insert('admin', $data);
            $this->email_model->account_opening('admin', $data['email'], $password);
        } else if ($para1 == 'edit') {
            $page_data['admin_data'] = $this->db->get_where('admin', array(
                'admin_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/admin_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['name']    = $this->input->post('name');
            $data['email']   = $this->input->post('email');
            $data['phone']   = $this->input->post('phone');
            $data['address'] = $this->input->post('address');
            $data['role']    = $this->input->post('role');
            $this->db->where('admin_id', $para2);
            $this->db->update('admin', $data);
        } elseif ($para1 == 'delete') {
            $this->db->where('admin_id', $para2);
            $this->db->delete('admin');
        } elseif ($para1 == 'list') {
            $this->db->order_by('admin_id', 'desc');
            $page_data['all_admins'] = $this->db->get('admin')->result_array();
            $this->load->view('back/admin/admin_list', $page_data);
        } elseif ($para1 == 'view') {
            $page_data['admin_data'] = $this->db->get_where('admin', array(
                'admin_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/admin_view', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/admin_add');
        } else {
            $page_data['page_name']  = "admin";
            $page_data['all_admins'] = $this->db->get('admin')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Account Role Management */
    function role($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('role')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['name']        = $this->input->post('name');
            $data['permission']  = json_encode($this->input->post('permission'));
            $data['description'] = $this->input->post('description');
            $this->db->insert('role', $data);
        } elseif ($para1 == "update") {
            $data['name']        = $this->input->post('name');
            $data['permission']  = json_encode($this->input->post('permission'));
            $data['description'] = $this->input->post('description');
            $this->db->where('role_id', $para2);
            $this->db->update('role', $data);
        } elseif ($para1 == 'delete') {
            $this->db->where('role_id', $para2);
            $this->db->delete('role');
        } elseif ($para1 == 'list') {
            $this->db->order_by('role_id', 'desc');
            $page_data['all_roles'] = $this->db->get('role')->result_array();
            $this->load->view('back/admin/role_list', $page_data);
        } elseif ($para1 == 'view') {
            $page_data['role_data'] = $this->db->get_where('role', array(
                'role_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/role_view', $page_data);
        } elseif ($para1 == 'add') {
            $page_data['all_permissions'] = $this->db->get('permission')->result_array();
            $this->load->view('back/admin/role_add', $page_data);
        } else if ($para1 == 'edit') {
            $page_data['all_permissions'] = $this->db->get('permission')->result_array();
            $page_data['role_data']       = $this->db->get_where('role', array(
                'role_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/role_edit', $page_data);
        } else {
            $page_data['page_name'] = "role";
            $page_data['all_roles'] = $this->db->get('role')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    
    /* Checking if email exists*/
    function load_dropzone()
    {
        $this->load->view('back/admin/dropzone');
    }

    /* Checking if email exists*/
    function exists()
    {
        $email  = $this->input->post('email');
        $admin  = $this->db->get('admin')->result_array();
        $exists = 'no';
        foreach ($admin as $row) {
            if ($row['email'] == $email) {
                $exists = 'yes';
            }
        }
        echo $exists;
    }
    
    /* Login into Admin panel */
    function login($para1 = '')
    {
        if ($para1 == 'forget_form') {
            $page_data['control'] = 'vendor';
            $this->load->view('back/forget_password',$page_data);
        } else if ($para1 == 'forget') {
			
        	$this->load->library('form_validation');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');			
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
				$query = $this->db->get_where('admin', array(
					'email' => $this->input->post('email')
				));
				if ($query->num_rows() > 0) {
					$admin_id         = $query->row()->admin_id;
					$password         = substr(hash('sha512', rand()), 0, 12);
					$data['password'] = sha1($password);
					$this->db->where('admin_id', $admin_id);
					$this->db->update('admin', $data);
					if ($this->email_model->password_reset_email('admin', $admin_id, $password)) {
						echo 'email_sent';
					} else {
						echo 'email_not_sent';
					}
				} else {
					echo 'email_nay';
				}
			}
        } else {
        	$this->load->library('form_validation');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required');
			
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
				$login_data = $this->db->get_where('admin', array(
					'email' => $this->input->post('email'),
					'password' => sha1($this->input->post('password'))
				));
				if ($login_data->num_rows() > 0) {
					foreach ($login_data->result_array() as $row) {
						$this->session->set_userdata('login', 'yes');
						$this->session->set_userdata('admin_login', 'yes');
						$this->session->set_userdata('admin_id', $row['admin_id']);
						$this->session->set_userdata('admin_name', $row['name']);
						$this->session->set_userdata('title', 'admin');
						echo 'lets_login';
					}
				} else {
					echo 'login_failed';
				}
			}
        }
    }
    
    /* Loging out from Admin panel */
    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url() . 'index.php/admin', 'refresh');
    }
    
    /* Sending Newsletters */
    function newsletter($para1 = "")
    {
        if (!$this->crud_model->admin_permission('newsletter')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "send") {
            $users       = explode(',', $this->input->post('users'));
            $subscribers = explode(',', $this->input->post('subscribers'));
            $text        = $this->input->post('text');
            $title       = $this->input->post('title');
            $from        = $this->input->post('from');
            foreach ($users as $key => $user) {
                if ($user !== '') {
                    $this->email_model->newsletter($title, $text, $user, $from);
                }
            }
            foreach ($subscribers as $key => $subscriber) {
                if ($subscriber !== '') {
                    $this->email_model->newsletter($title, $text, $subscriber, $from);
                }
            }
        } else {
            $page_data['users']       = $this->db->get('user')->result_array();
            $page_data['subscribers'] = $this->db->get('subscribe')->result_array();
            $page_data['page_name']   = "newsletter";
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Add, Edit, Delete, Duplicate, Enable, Disable Sliders */
    function slider($para1 = '', $para2 = '', $para3 = '')
    {
        if ($para1 == 'list') {
            $this->db->order_by('slider_id', 'desc');
            $page_data['all_slider'] = $this->db->get('slider')->result_array();
            $this->load->view('back/admin/slider_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/slider_set');
        } elseif ($para1 == 'add_form') {
            $page_data['style_id'] = $para2;
            $data_slider = $this->db->get_where('slider_style', array(
                'slider_style_id' => $para2
            ))->row()->value;
            $re_data_slider = str_replace('\r\n', '', $data_slider);
            $page_data['style']    = json_decode($re_data_slider, true);
            $this->load->view('back/admin/slider_add_form', $page_data);
        } else if ($para1 == 'delete') { //ll
            $elements = json_decode($this->db->get_where('slider', array(
                'slider_id' => $para2
            ))->row()->elements, true);
            $style    = $this->db->get_where('slider', array(
                'slider_id' => $para2
            ))->row()->style;
            $style    = json_decode($this->db->get_where('slider_style', array(
                'slider_style_id' => $style
            ))->row()->value, true);
            $images   = $style['images'];
            if (file_exists('uploads/slider_image/background_' . $para2 . '.jpg')) {
                unlink('uploads/slider_image/background_' . $para2 . '.jpg');
            }
            foreach ($images as $row) {
                if (file_exists('uploads/slider_image/' . $para2 . '_' . $row . '.png')) {
                    unlink('uploads/slider_image/' . $para2 . '_' . $row . '.png');
                }
            }
            $this->db->where('slider_id', $para2);
            $this->db->delete('slider');
        } else if ($para1 == 'serial') {
            $this->db->order_by('serial', 'desc');
            $this->db->order_by('slider_id', 'desc');
            $page_data['slider'] = $this->db->get_where('slider', array(
                'status' => 'ok'
            ))->result_array();
            $this->load->view('back/admin/slider_serial', $page_data);
        } else if ($para1 == 'do_serial') {
            $input  = json_decode($this->input->post('serial'), true);
            $serial = array();
            foreach ($input as $r) {
                $serial[] = $r['id'];
            }
            $serial  = array_reverse($serial);
            $sliders = $this->db->get('slider')->result_array();
            foreach ($sliders as $row) {
                $data['serial'] = 0;
                $this->db->where('slider_id', $row['slider_id']);
                $this->db->update('slider', $data);
            }
            foreach ($serial as $i => $row) {
                $data1['serial'] = $i + 1;
                $this->db->where('slider_id', $row);
                $this->db->update('slider', $data1);
            }
        } else if ($para1 == 'slider_publish_set') {
            $slider = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
                $data['serial'] = 0;
            }
            $this->db->where('slider_id', $slider);
            $this->db->update('slider', $data);
        } else if ($para1 == 'edit') {
            $page_data['slider_data'] = $this->db->get_where('slider', array(
                'slider_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/slider_edit_form', $page_data);
        } elseif ($para1 == 'create') {
            $data['style']  = $this->input->post('style_id');
            $data['title']  = $this->input->post('title');
            $data['serial'] = 0;
            $data['status'] = 'ok';
            $style          = json_decode($this->db->get_where('slider_style', array(
                'slider_style_id' => $data['style']
            ))->row()->value, true);
            $images         = array();
            $texts          = array();
            foreach ($style['images'] as $image) {
                if ($_FILES[$image['name']]['name']) {
                    $images[] = $image['name'];
                }
            }
            foreach ($style['texts'] as $text) {
                if ($this->input->post($text['name']) !== '') {
                    $texts[] = array(
                        'name' => $text['name'],
                        'text' => $this->input->post($text['name']),
                        'color' => $this->input->post($text['name'] . '_color'),
                        'background' => $this->input->post($text['name'] . '_background')
                    );
                }
            }
            $elements         = array(
                'images' => $images,
                'texts' => $texts
            );
            $data['elements'] = json_encode($elements);
            $this->db->insert('slider', $data);
            $id = $this->db->insert_id();
            
            move_uploaded_file($_FILES['background']['tmp_name'], 'uploads/slider_image/background_' . $id . '.jpg');
            foreach ($elements['images'] as $image) {
                move_uploaded_file($_FILES[$image]['tmp_name'], 'uploads/slider_image/' . $id . '_' . $image . '.png');
            }
        } elseif ($para1 == 'update') {
            $data['style'] = $this->input->post('style_id');
            $data['title'] = $this->input->post('title');
            $style         = json_decode($this->db->get_where('slider_style', array(
                'slider_style_id' => $data['style']
            ))->row()->value, true);
            $images        = array();
            $texts         = array();
            foreach ($style['images'] as $image) {
                if ($_FILES[$image['name']]['name'] || $this->input->post($image['name'] . '_same') == 'same') {
                    $images[] = $image['name'];
                }
            }
            foreach ($style['texts'] as $text) {
                if ($this->input->post($text['name']) !== '') {
                    $texts[] = array(
                        'name' => $text['name'],
                        'text' => $this->input->post($text['name']),
                        'color' => $this->input->post($text['name'] . '_color'),
                        'background' => $this->input->post($text['name'] . '_background')
                    );
                }
            }
            $elements         = array(
                'images' => $images,
                'texts' => $texts
            );
            $data['elements'] = json_encode($elements);
            $this->db->where('slider_id', $para2);
            $this->db->update('slider', $data);
            
            move_uploaded_file($_FILES['background']['tmp_name'], 'uploads/slider_image/background_' . $para2 . '.jpg');
            foreach ($elements['images'] as $image) {
                move_uploaded_file($_FILES[$image]['tmp_name'], 'uploads/slider_image/' . $para2 . '_' . $image . '.png');
            }
        } else {
            $page_data['page_name'] = "slider";
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Manage Frontend User Interface */
    function ui_settings($para1 = '', $para2 = '')
    {
        $page_data ='';
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "ui_home") {
            if ($para2 == 'update') {
                $this->db->where('type', "side_bar_pos");
                $this->db->update('ui_settings', array(
                    'value' => $this->input->post('side_bar_pos')
                ));
                $this->db->where('type', "latest_item_div");
                $this->db->update('ui_settings', array(
                    'value' => $this->input->post('latest_item_div')
                ));
                $this->db->where('type', "most_popular_div");
                $this->db->update('ui_settings', array(
                    'value' => $this->input->post('most_popular_div')
                ));
                $this->db->where('type', "most_view_div");
                $this->db->update('ui_settings', array(
                    'value' => $this->input->post('most_view_div')
                ));
                $this->db->where('type', "home_category");
                $this->db->update('ui_settings', array(
                    'value' => json_encode($this->input->post('category'))
                ));
                $this->db->where('type', "home_brand");
                $this->db->update('ui_settings', array(
                    'value' => json_encode($this->input->post('brand'))
                ));
                redirect(base_url() . 'index.php/admin/page_settings/home/', 'refresh');
            }
        }
        if ($para1 == "ui_category") {
            if ($para2 == 'update') {
                $this->db->where('type', "side_bar_pos_category");
                $this->db->update('ui_settings', array(
                    'value' => $this->input->post('side_bar_pos')
                ));
                redirect(base_url() . 'index.php/admin/page_settings/category_page/', 'refresh');
            }
        }
        $this->load->view('back/index', $page_data);
    }
    
    /* Checking Login Stat */
    function is_logged()
    {
        if ($this->session->userdata('admin_login') == 'yes') {
            echo 'yah!good';
        } else {
            echo 'nope!bad';
        }
    }
    
    /* Manage Frontend User Interface */
    function page_settings($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        $page_data['page_name'] = "page_settings";
        $page_data['tab_name']  = $para1;
        $this->load->view('back/index', $page_data);
    }
    
    /* Manage Frontend User Messages */
    function contact_message($para1 = "", $para2 = "")
    {
        if (!$this->crud_model->admin_permission('contact_message')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'delete') {
            $this->db->where('contact_message_id', $para2);
            $this->db->delete('contact_message');
        } elseif ($para1 == 'list') {
            $this->db->order_by('contact_message_id', 'desc');
            $page_data['contact_messages'] = $this->db->get('contact_message')->result_array();
            $this->load->view('back/admin/contact_message_list', $page_data);
        } elseif ($para1 == 'reply') {
            $data['reply'] = $this->input->post('reply');
            $this->db->where('contact_message_id', $para2);
            $this->db->update('contact_message', $data);
            $this->db->order_by('contact_message_id', 'desc');
            $query = $this->db->get_where('contact_message', array(
                'contact_message_id' => $para2
            ))->row();
            $this->email_model->do_email($data['reply'], 'RE: ' . $query->subject, $query->email);
        } elseif ($para1 == 'view') {
            $page_data['message_data'] = $this->db->get_where('contact_message', array(
                'contact_message_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/contact_message_view', $page_data);
        } elseif ($para1 == 'reply_form') {
            $page_data['message_data'] = $this->db->get_where('contact_message', array(
                'contact_message_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/contact_message_reply', $page_data);
        } else {
            $page_data['page_name']        = "contact_message";
            $page_data['contact_messages'] = $this->db->get('contact_message')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Manage Logos */
    function logo_settings($para1 = "", $para2 = "", $para3 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "select_logo") {
            $page_data['page_name'] = "select_logo";
        } elseif ($para1 == "delete_logo") {
            if (file_exists("uploads/logo_image/logo_" . $para2 . ".png")) {
                unlink("uploads/logo_image/logo_" . $para2 . ".png");
            }
            $this->db->where('logo_id', $para2);
            $this->db->delete('logo');
        } elseif ($para1 == "set_logo") {
            $type    = $this->input->post('type');
            $logo_id = $this->input->post('logo_id');
            $this->db->where('type', $type);
            $this->db->update('ui_settings', array(
                'value' => $logo_id
            ));
        } elseif ($para1 == "show_all") {
            $page_data['logo'] = $this->db->get('logo')->result_array();
            if ($para2 == "") {
                $this->load->view('back/admin/all_logo', $page_data);
            }
            if ($para2 == "selectable") {
                $page_data['logo_type'] = $para3;
                $this->load->view('back/admin/select_logo', $page_data);
            }
        } elseif ($para1 == "upload_logo") {
            foreach ($_FILES["file"]['name'] as $i => $row) {
                $data['name'] = '';
                $this->db->insert("logo", $data);
                $id = $this->db->insert_id();
                move_uploaded_file($_FILES["file"]['tmp_name'][$i], 'uploads/logo_image/logo_' . $id . '.png');
            }
            return;
        } else {
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Manage Favicons */
    function favicon_settings($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        $name = $_FILES["fav"]["name"];
        $ext  = end((explode(".", $name)));
        move_uploaded_file($_FILES["fav"]['tmp_name'], 'uploads/others/favicon.' . $ext);
        $this->db->where('type', "fav_ext");
        $this->db->update('ui_settings', array(
            'value' => $ext
        ));
    }
    
    /* Manage Frontend Facebook Login Credentials */
    function social_login_settings($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        $this->db->where('type', "fb_appid");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('appid')
        ));
        $this->db->where('type', "fb_secret");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('secret')
        ));
        $this->db->where('type', "application_name");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('application_name')
        ));
        $this->db->where('type', "client_id");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('client_id')
        ));
        $this->db->where('type', "client_secret");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('client_secret')
        ));
        $this->db->where('type', "redirect_uri");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('redirect_uri')
        ));
        $this->db->where('type', "api_key");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('api_key')
        ));
    }
    
    /* Manage Frontend Facebook Login Credentials */
    function product_comment($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        $this->db->where('type', "discus_id");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('discus_id')
        ));
        $this->db->where('type', "comment_type");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('type')
        ));
        $this->db->where('type', "fb_comment_api");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('fb_comment_api')
        ));
    }
    
    /* Manage Frontend Captcha Settings Credentials */
    function captcha_settings($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        $this->db->where('type', "captcha_public");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('cpub')
        ));
        $this->db->where('type', "captcha_private");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('cprv')
        ));
    }
    
    /* Manage Site Settings */
    function restaurant_detail($para1 = "")
    {
        if (!$this->crud_model->admin_permission('restaurant_detail')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "set") {
            $this->crud_model->file_up("pic", "restaurant_service", 'image','');          
            $this->db->where('type', "restaurants_service_detail");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('restaurants_service_detail')
            ));
            $this->db->where('type', "restaurants_service_pic_detail");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('restaurants_service_pic_detail')
            ));
            $this->db->where('type', "restaurants_service_detail_en");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('restaurants_service_detail_en')
            ));
            $this->db->where('type', "restaurants_service_pic_detail_en");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('restaurants_service_pic_detail_en')
            ));
            $this->db->where('type', "restaurants_service_phone");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('restaurants_service_phone')
            ));
            $this->db->where('type', "restaurants_service_tel");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('restaurants_service_tel')
            ));
            

        }
        else {
            require_once (APPPATH . 'libraries/SEOstats/bootstrap.php');
            $page_data['page_name'] = "restaurant_detail";
            $this->load->view('back/index', $page_data);
        }
    }
    
    function site_settings($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        $page_data['page_name'] = "site_settings";
        $page_data['tab_name']  = $para1;
        $this->load->view('back/index', $page_data);
    }

    /* Manage Languages */
    function language_settings($para1 = "", $para2 = "", $para3 = "")
    {
        if (!$this->crud_model->admin_permission('language')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'add_lang') {
            $this->load->view('back/admin/language_add');
        } elseif ($para1 == 'lang_list') {
            //if($para2 !== ''){
            $this->db->order_by('word_id', 'desc');
            $page_data['words'] = $this->db->get('language')->result_array();
            $page_data['lang']  = $para2;
            $this->load->view('back/admin/language_list', $page_data);
            //}
        } elseif ($para1 == 'add_word') {
            $page_data['lang'] = $para2;
            $this->load->view('back/admin/language_word_add', $page_data);
        } elseif ($para1 == 'upd_trn') {
            $word_id     = $para2;
            $translation = $this->input->post('translation');
            $language    = $this->input->post('lang');
            $word        = $this->db->get_where('language', array(
                'word_id' => $word_id
            ))->row()->word;
            add_translation($word, $language, $translation);
        } elseif ($para1 == 'do_add_word') {
            $language = $para2;
            $word     = $this->input->post('word');
            add_lang_word($word);
        } elseif ($para1 == 'do_add_lang') {
            $language = $this->input->post('language');
            add_language($language);
        } elseif ($para1 == 'check_existed') {
            echo lang_check_exists($para2);
        } elseif ($para1 == 'lang_select') {
            $this->load->view('back/admin/language_select');
        } elseif ($para1 == 'dlt_lang') {
            $this->load->dbforge();
            $this->dbforge->drop_column('language', $para2);
        } elseif ($para1 == 'dlt_word') {
            $this->db->where('word_id', $para2);
            $this->db->delete('language');
        } else {
            $page_data['page_name'] = "language";
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Manage Business Settings */
    function business_settings($para1 = "", $para2 = "")
    {
        if (!$this->crud_model->admin_permission('business_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "cash_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('type', "cash_set");
            $this->db->update('business_settings', array(
                'value' => $val
            ));
        }
        if ($para1 == "paypal_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('type', "paypal_set");
            $this->db->update('business_settings', array(
                'value' => $val
            ));
        }
        if ($para1 == "stripe_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('type', "stripe_set");
            $this->db->update('business_settings', array(
                'value' => $val
            ));
        }
        if ($para1 == 'set') {
            $this->db->where('type', "paypal_email");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('paypal_email')
            ));
            $this->db->where('type', "paypal_type");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('paypal_type')
            ));
            $this->db->where('type', "stripe_secret");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('stripe_secret')
            ));
            $this->db->where('type', "stripe_publishable");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('stripe_publishable')
            ));
            $this->db->where('type', "currency");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('currency')
            ));

            $this->db->where('type', "shipment_condition");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('shipment_condition')
            ));

            $this->db->where('type', "shipment_condition_detail");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('shipment_condition_detail')
            ));

            $this->db->where('type', "currency_name");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('currency_name')
            ));

            $this->db->where('type', "exchange");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('exchange')
            ));
            $this->db->where('type', "shipping_cost_type");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('shipping_cost_type')
            ));
            $this->db->where('type', "shipping_cost");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('shipping_cost')
            ));
            $this->db->where('type', "shipment_info");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('shipment_info')
            ));
            $faqs = array();
            $f_q  = $this->input->post('f_q');
            $f_a  = $this->input->post('f_a');
            foreach ($f_q as $i => $r) {
                $faqs[] = array(
                    'question' => $f_q[$i],
                    'answer' => $f_a[$i]
                );
            }
            $this->db->where('type', "faqs");
            $this->db->update('business_settings', array(
                'value' => json_encode($faqs)
            ));
        } else {
            $page_data['page_name'] = "business_settings";
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Manage Admin Settings */
    function manage_admin($para1 = "")
    {
        if ($this->session->userdata('admin_login') != 'yes') {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'update_password') {
            $user_data['password'] = $this->input->post('password');
            $account_data          = $this->db->get_where('admin', array(
                'admin_id' => $this->session->userdata('admin_id')
            ))->result_array();
            foreach ($account_data as $row) {
                if (sha1($user_data['password']) == $row['password']) {
                    if ($this->input->post('password1') == $this->input->post('password2')) {
                        $data['password'] = sha1($this->input->post('password1'));
                        $this->db->where('admin_id', $this->session->userdata('admin_id'));
                        $this->db->update('admin', $data);
                        echo 'updated';
                    }
                } else {
                    echo 'pass_prb';
                }
            }
        } else if ($para1 == 'update_profile') {
            $this->db->where('admin_id', $this->session->userdata('admin_id'));
            $this->db->update('admin', array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'phone' => $this->input->post('phone')
            ));
        } else {
            $page_data['page_name'] = "manage_admin";
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*Page Management */
    function page($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('page')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $parts             = array();
            $data['page_name'] = $this->input->post('page_name');
            $data['parmalink'] = $this->input->post('parmalink');
            $size              = $this->input->post('part_size');
            $type              = $this->input->post('part_content_type');
            $content           = $this->input->post('part_content');
            $widget            = $this->input->post('part_widget');
            var_dump($widget);
            foreach ($size as $in => $row) {
                $parts[] = array(
                    'size' => $size[$in],
                    'type' => $type[$in],
                    'content' => $content[$in],
                    'widget' => $widget[$in]
                );
            }
            $data['parts']  = json_encode($parts);
            $data['status'] = 'ok';
            $this->db->insert('page', $data);
        } else if ($para1 == 'edit') {
            $page_data['page_data'] = $this->db->get_where('page', array(
                'page_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/page_edit', $page_data);
        } elseif ($para1 == "update") {
            $parts             = array();
            $data['page_name'] = $this->input->post('page_name');
            $data['parmalink'] = $this->input->post('parmalink');
            $size              = $this->input->post('part_size');
            $type              = $this->input->post('part_content_type');
            $content           = $this->input->post('part_content');
            $widget            = $this->input->post('part_widget');
            var_dump($widget);
            foreach ($size as $in => $row) {
                $parts[] = array(
                    'size' => $size[$in],
                    'type' => $type[$in],
                    'content' => $content[$in],
                    'widget' => $widget[$in]
                );
            }
            $data['parts'] = json_encode($parts);
            $this->db->where('page_id', $para2);
            $this->db->update('page', $data);
        } elseif ($para1 == 'delete') {
            $this->db->where('page_id', $para2);
            $this->db->delete('page');
        } elseif ($para1 == 'list') {
            $this->db->order_by('page_id', 'desc');
            $page_data['all_page'] = $this->db->get('page')->result_array();
            $this->load->view('back/admin/page_list', $page_data);
        } else if ($para1 == 'page_publish_set') {
            $page = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('page_id', $page);
            $this->db->update('page', $data);
        } elseif ($para1 == 'view') {
            $page_data['page_data'] = $this->db->get_where('page', array(
                'page_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/page_view', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/page_add');
        } else {
            $page_data['page_name'] = "page";
            $page_data['all_pages'] = $this->db->get('page')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Manage General Settings */
    function general_settings($para1 = "", $para2 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "terms") {
            $this->db->where('type', "terms_conditions");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('terms')
            ));
        }
        if ($para1 == "privacy_policy") {
            $this->db->where('type', "privacy_policy");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('privacy_policy')
            ));
        }
        if ($para1 == "set_slider") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            $this->db->where('type', "slider");
            $this->db->update('general_settings', array(
                'value' => $val
            ));
        }
        if ($para1 == "set_admin_notification_sound") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }            $this->db->where('type', "admin_notification_sound");
            $this->db->update('general_settings', array(
                'value' => $val
            ));
        }
        if ($para1 == "set_home_notification_sound") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            $this->db->where('type', "home_notification_sound");
            $this->db->update('general_settings', array(
                'value' => $val
            ));
        }
        if ($para1 == "fb_login_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('type', "fb_login_set");
            $this->db->update('general_settings', array(
                'value' => $val
            ));
        }
        if ($para1 == "g_login_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('type', "g_login_set");
            $this->db->update('general_settings', array(
                'value' => $val
            ));
        }
        if ($para1 == "set") {
            $this->db->where('type', "system_name");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('system_name')
            ));
            $this->db->where('type', "system_email");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('system_email')
            ));
            $this->db->where('type', "system_title");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('system_title')
            ));


            $this->db->where('type', "cache_time");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('cache_time')
            ));
            $this->db->where('type', "vendor_system");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('vendor_system')
            ));
            $this->db->where('type', "language");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('language')
            ));
            $volume = $this->input->post('admin_notification_volume');
            $this->db->where('type', "admin_notification_volume");
            $this->db->update('general_settings', array(
                'value' => $volume
            ));
            $volume = $this->input->post('homepage_notification_volume');
            $this->db->where('type', "homepage_notification_volume");
            $this->db->update('general_settings', array(
                'value' => $volume
            ));
        }
        if ($para1 == "contact") {
            $this->db->where('type', "contact_address");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('contact_address')
            ));
            $this->db->where('type', "contact_email");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('contact_email')
            ));
            $this->db->where('type', "contact_phone");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('contact_phone')
            ));
            $this->db->where('type', "contact_website");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('contact_website')
            ));
            $this->db->where('type', "contact_about");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('contact_about')
            ));
        }
        if ($para1 == "footer") {
            $this->db->where('type', "footer_text");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('footer_text', 'chaira_de')
            ));
            $this->db->where('type', "footer_category");
            $this->db->update('general_settings', array(
                'value' => json_encode($this->input->post('footer_category'))
            ));
        }
        if ($para1 == "color") {
            $this->db->where('type', "header_color");
            $this->db->update('ui_settings', array(
                'value' => $this->input->post('header_color')
            ));
            $this->db->where('type', "footer_color");
            $this->db->update('ui_settings', array(
                'value' => $this->input->post('footer_color')
            ));
        }
    }
    
    /* Manage Social Links */
    function social_links($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "set") {
            $this->db->where('type', "facebook");
            $this->db->update('social_links', array(
                'value' => $this->input->post('facebook')
            ));
            $this->db->where('type', "google-plus");
            $this->db->update('social_links', array(
                'value' => $this->input->post('google-plus')
            ));
            $this->db->where('type', "twitter");
            $this->db->update('social_links', array(
                'value' => $this->input->post('twitter')
            ));
            $this->db->where('type', "skype");
            $this->db->update('social_links', array(
                'value' => $this->input->post('skype')
            ));
            $this->db->where('type', "pinterest");
            $this->db->update('social_links', array(
                'value' => $this->input->post('pinterest')
            ));
            $this->db->where('type', "youtube");
            $this->db->update('social_links', array(
                'value' => $this->input->post('youtube')
            ));
            $this->db->where('type', "instagram");
            $this->db->update('social_links', array(
                'value' => $this->input->post('instagram')
            ));
            redirect(base_url() . 'index.php/admin/site_settings/social_links/', 'refresh');
        }
    }
    /* Manage SEO relateds */
    function seo_settings($para1 = "")
    {
        if (!$this->crud_model->admin_permission('seo')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "set") {
            $this->db->where('type', "meta_description");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('description')
            ));
            $this->db->where('type', "meta_keywords");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('keywords')
            ));
            $this->db->where('type', "meta_author");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('author')
            ));

            $this->db->where('type', "revisit_after");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('revisit_after')
            ));
        }
        else {
            require_once (APPPATH . 'libraries/SEOstats/bootstrap.php');
            $page_data['page_name'] = "seo";
            $this->load->view('back/index', $page_data);
        }
    }


    /* Manage Policy Settings */
    function policy($para1 = "",$para2 = "")
    {
        if (!$this->crud_model->admin_permission('policy')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['policy_name'] = $this->input->post('policy_name');
            $data['policy_detail'] = $this->input->post('policy_detail');
            $data['create_by']   = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['create_date'] = date("Y-m-d H:i:s");
            $this->db->insert('policy', $data);
            redirect(base_url() . 'index.php/admin/policy/', 'refresh');
        } else if ($para1 == 'edit') {
            $page_data['policy_data'] = $this->db->get_where('policy', array(
                'id' => $para2
            ))->result_array();
            $this->load->view('back/admin/policy_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['policy_name'] = $this->input->post('policy_name');
            $data['policy_detail'] = $this->input->post('policy_detail');
            $data['update_by'] = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['update_date'] = date("Y-m-d H:i:s");
            $this->db->where('id', $para2);
            $this->db->update('policy', $data);
            redirect(base_url() . 'index.php/admin/policy/', 'refresh');
        } elseif ($para1 == 'delete') {
            $this->db->where('id', $para2);
            $this->db->delete('policy');
        } elseif ($para1 == 'list') {
            $this->db->order_by('id', 'desc');
            $page_data['all_policies'] = $this->db->get('policy')->result_array();
            $this->load->view('back/admin/policy_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/policy_add');
        } else {
            $page_data['page_name']      = "policy";
            $page_data['all_policies'] = $this->db->get('policy')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }


    /* Manage Policy Settings */
    function store_locations($para1 = "",$para2 = "")
    {
        if (!$this->crud_model->admin_permission('store_locations')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            if ($_FILES["images"]['name'][0] == '') {
                $num_of_imgs = 0;
            } else {
                $num_of_imgs = count($_FILES["images"]['name']);
            }
            $data['store_name'] = $this->input->post('store_name');
            $data['store_detail'] = $this->input->post('store_detail');
            $data['num_of_imgs'] = $num_of_imgs;
            $data['latitude'] = $this->input->post('latitude');
            $data['longitude'] = $this->input->post('longitude');
            $data['map_zoom'] = $this->input->post('map_zoom');
            $data['create_by']   = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['create_date'] = date("Y-m-d H:i:s");
            $this->db->insert('store_locations', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("images", "store_locations", $id, 'multi');
            $this->crud_model->file_up("cover", "store_locations", $id, '');
            $this->crud_model->file_up("map", "store_locations_map", $id, '');
            redirect(base_url() . 'index.php/admin/store_locations/', 'refresh');
        } else if ($para1 == 'edit') {
            $page_data['store_data'] = $this->db->get_where('store_locations', array(
                'id' => $para2
            ))->result_array();
            $this->load->view('back/admin/store_locations_edit', $page_data);
        } elseif ($para1 == "update") {
            if ($_FILES["images"]['name'][0] == '') {
                $num_of_imgs = 0;
            } else {
                $num_of_imgs = count($_FILES["images"]['name']);
            }
            $num = $this->crud_model->get_type_name_by_id_only('store_locations', $para2, 'num_of_imgs');
            $data['store_name'] = $this->input->post('store_name');
            $data['store_detail'] = $this->input->post('store_detail');
            $data['num_of_imgs'] = $num + $num_of_imgs;
            $data['latitude'] = $this->input->post('latitude');
            $data['longitude'] = $this->input->post('longitude');
            $data['map_zoom'] = $this->input->post('map_zoom');
            $data['update_by'] = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['update_date'] = date("Y-m-d H:i:s");
            $this->db->where('id', $para2);
            $this->db->update('store_locations', $data);
            $this->crud_model->file_up("images", "store_locations", $para2, 'multi');
            $this->crud_model->file_up("cover", "store_locations", $para2, '');
            $this->crud_model->file_up("map", "store_locations_map", $para2, '');
            redirect(base_url() . 'index.php/admin/store_locations/', 'refresh');
        } else if ($para1 == 'dlt_img') {
            $a = explode('_', $para2);
            $this->crud_model->file_dlt('store_locations', $a[0], '.jpg', 'multi_id', $a[1]);
        } elseif ($para1 == 'delete') {
            $this->db->where('id', $para2);
            $this->db->delete('store_locations');
        } elseif ($para1 == 'list') {
            $this->db->order_by('id', 'desc');
            $page_data['all_store'] = $this->db->get('store_locations')->result_array();
            $this->load->view('back/admin/store_locations_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/store_locations_add');
        } else {
            $page_data['page_name']      = "store_locations";
            $page_data['all_store'] = $this->db->get('store_locations')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }



    /*Bank*/
    function bank($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('bank')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['bank_name'] = $this->input->post('bank_name');
            $data['bank_number'] = $this->input->post('bank_number');
            $data['bank_detail'] = $this->input->post('bank_detail');
            $data['bank_our'] = $this->input->post('bank_our');
            $data['bank_branch'] = $this->input->post('bank_branch');
            $data['create_by']   = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['create_date'] = date("Y-m-d H:i:s");
            $this->db->insert('bank', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("images", "bank", $id, '');
        } else if ($para1 == 'edit') {
            $page_data['bank_data'] = $this->db->get_where('bank', array(
                'id' => $para2
            ))->result_array();
            $this->load->view('back/admin/bank_edit', $page_data);
        } elseif ($para1 == "update") {

            $data['bank_name'] = $this->input->post('bank_name');
            $data['bank_number'] = $this->input->post('bank_number');
            $data['bank_detail'] = $this->input->post('bank_detail');
            $data['bank_our'] = $this->input->post('bank_our');
            $data['bank_branch'] = $this->input->post('bank_branch');
            $data['update_by']           = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['update_date'] = date("Y-m-d H:i:s");
            $this->crud_model->file_up("images", "bank", $para2, '');
            $this->db->where('id', $para2);
            $this->db->update('bank', $data);

        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('bank', $para2, '.jpg', '');
            $this->db->where('id', $para2);
            $this->db->delete('bank');
        } elseif ($para1 == 'list') {
            $this->db->order_by('id', 'desc');
            $page_data['all_banks'] = $this->db->get('bank')->result_array();
            $this->load->view('back/admin/bank_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/bank_add');
        } else {
            $page_data['page_name']      = "bank";
            $page_data['all_banks'] = $this->db->get('bank')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }


    /*Bank*/
    function remark($para1 = '')
    {
        if($para1=="update"){
            $this->db->where('type', "remark_head");
            $this->db->update('general_settings', array(
                'value' => $_POST['remark_head']
            ));
            $this->db->where('type', "remark_footer");
            $this->db->update('general_settings', array(
                'value' => $_POST['remark_footer']
            ));
            redirect(base_url() . 'index.php/admin/remark/', 'refresh');
        }
        $page_data['page_name'] = "remark";
        $this->load->view('back/index',$page_data);
    }


    /*payment method*/
    function payment_method($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('payment_method')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['payment_name'] = $this->input->post('payment_name');
            $data['payment_type'] = $this->input->post('payment_type');
            $data['payment_detail'] = $this->input->post('payment_detail');
            $data['create_by']   = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['create_date'] = date("Y-m-d H:i:s");
            $this->db->insert('payment_method', $data);
            $id = $this->db->insert_id();
            exit();
            $this->crud_model->file_up("images", "payment_method", $id, '');
            redirect(base_url() . 'index.php/admin/payment_method/', 'refresh');
        } else if ($para1 == 'edit') {
            $page_data['payment_data'] = $this->db->get_where('payment_method', array(
                'id' => $para2
            ))->result_array();
            $this->load->view('back/admin/payment_method_edit', $page_data);

        } elseif ($para1 == "update") {

            $data['payment_name'] = $this->input->post('payment_name');
            $data['payment_type'] = $this->input->post('payment_type');
            $data['payment_detail'] = $this->input->post('payment_detail');
            $data['update_by']           = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['update_date'] = date("Y-m-d H:i:s");
            $this->crud_model->file_up("images", "payment_method", $para2, '');
            $this->db->where('id', $para2);
            $this->db->update('payment_method', $data);
            exit();
            redirect(base_url() . 'index.php/admin/payment_method/', 'refresh');
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('payment_method', $para2, '.jpg', '');
            $this->db->where('id', $para2);
            $this->db->delete('payment_method');
            redirect(base_url() . 'index.php/admin/payment_method/', 'refresh');
        } elseif ($para1 == 'list') {
            $this->db->order_by('id', 'desc');
            $page_data['all_payments'] = $this->db->get('payment_method')->result_array();
            $this->load->view('back/admin/payment_method_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/payment_method_add');
        } else {
            $page_data['page_name']      = "payment_method";
            $page_data['all_payments'] = $this->db->get('payment_method')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }

    function recommended_menus($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('recommended_menus')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['menu_name'] = $this->input->post('menu_name');
            $data['menu_name_en'] = $this->input->post('menu_name_en');
            $data['menu_detail'] = $this->input->post('menu_detail');
            $data['menu_detail_en'] = $this->input->post('menu_detail_en');
            $data['create_by']   = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['create_date'] = date("Y-m-d H:i:s");
            $this->db->insert('recommended_menus', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("images", "recommended_menus", $id, '');
            redirect(base_url() . 'index.php/admin/recommended_menus/', 'refresh');
        } else if ($para1 == 'edit') {
            $page_data['menu_data'] = $this->db->get_where('recommended_menus', array(
                'id' => $para2
            ))->result_array();
            $this->load->view('back/admin/recommended_menus_edit', $page_data);

        } elseif ($para1 == "update") {

            $data['menu_name'] = $this->input->post('menu_name');
            $data['menu_name_en'] = $this->input->post('menu_name_en');
            $data['menu_detail'] = $this->input->post('menu_detail');
            $data['menu_detail_en'] = $this->input->post('menu_detail_en');
            $data['update_by']           = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['update_date'] = date("Y-m-d H:i:s");
            $this->crud_model->file_up("images", "recommended_menus", $para2, '');
            $this->db->where('id', $para2);
            $this->db->update('recommended_menus', $data);
            redirect(base_url() . 'index.php/admin/recommended_menus/', 'refresh');
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('recommended_menus', $para2, '.jpg', '');
            $this->db->where('id', $para2);
            $this->db->delete('recommended_menus');
            redirect(base_url() . 'index.php/admin/recommended_menus/', 'refresh');
        } elseif ($para1 == 'list') {
            $this->db->order_by('id', 'desc');
            $page_data['all_activity'] = $this->db->get('recommended_menus')->result_array();
            $this->load->view('back/admin/recommended_menus_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/recommended_menus_add');
        } else {
            $page_data['page_name']      = "recommended_menus";
            $page_data['all_activity'] = $this->db->get('recommended_menus')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }


    /*event_activity*/
    function event_activity($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('event_activity')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['activity_name'] = $this->input->post('activity_name');
            $data['activity_name_en'] = $this->input->post('activity_name_en');
            $data['activity_detail'] = $this->input->post('activity_detail');
            $data['activity_detail_en'] = $this->input->post('activity_detail_en');
            $data['create_by']   = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['create_date'] = date("Y-m-d H:i:s");
            $this->db->insert('event_activity', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("images", "event_activity", $id, '');
            redirect(base_url() . 'index.php/admin/event_activity/', 'refresh');
        } else if ($para1 == 'edit') {
            $page_data['activity_data'] = $this->db->get_where('event_activity', array(
                'id' => $para2
            ))->result_array();
            $this->load->view('back/admin/news_event_edit', $page_data);

        } elseif ($para1 == "update") {

            $data['activity_name'] = $this->input->post('activity_name');
            $data['activity_name_en'] = $this->input->post('activity_name_en');
            $data['activity_detail'] = $this->input->post('activity_detail');
            $data['activity_detail_en'] = $this->input->post('activity_detail_en');
            $data['update_by']           = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['update_date'] = date("Y-m-d H:i:s");
            $this->crud_model->file_up("images", "event_activity", $para2, '');
            $this->db->where('id', $para2);
            $this->db->update('event_activity', $data);
            redirect(base_url() . 'index.php/admin/event_activity/', 'refresh');
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('event_activity', $para2, '.jpg', '');
            $this->db->where('id', $para2);
            $this->db->delete('event_activity');
            redirect(base_url() . 'index.php/admin/event_activity/', 'refresh');
        } elseif ($para1 == 'list') {
            $this->db->order_by('id', 'desc');
            $page_data['all_activity'] = $this->db->get('event_activity')->result_array();
            $this->load->view('back/admin/news_event_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/news_event_add');
        } else {
            $page_data['page_name']      = "news_event";
            $page_data['all_activity'] = $this->db->get('event_activity')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }

    function vdo_clips($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('vdo_clips')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['vdo_clips_name'] = $this->input->post('vdo_clips_name');
            $data['vdo_clips_name_en'] = $this->input->post('vdo_clips_name_en');
            $data['vdo_clips_detail'] = $this->input->post('vdo_clips_detail');
            $data['vdo_clips_detail_en'] = $this->input->post('vdo_clips_detail_en');
            $data['vdo_clips_link'] = $this->input->post('vdo_clips_link');
            $data['create_by']   = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['create_date'] = date("Y-m-d H:i:s");
            $this->db->insert('vdo_clips', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("images", "vdo_clips", $id, '');
            redirect(base_url() . 'index.php/admin/vdo_clips/', 'refresh');
        } else if ($para1 == 'edit') {
            $page_data['vdo_clips_data'] = $this->db->get_where('vdo_clips', array(
                'id' => $para2
            ))->result_array();
            $this->load->view('back/admin/vdo_clips_edit', $page_data);

        } elseif ($para1 == "update") {

            $data['vdo_clips_name'] = $this->input->post('vdo_clips_name');
            $data['vdo_clips_name_en'] = $this->input->post('vdo_clips_name_en');
            $data['vdo_clips_detail'] = $this->input->post('vdo_clips_detail');
            $data['vdo_clips_detail_en'] = $this->input->post('vdo_clips_detail_en');
            $data['vdo_clips_link'] = $this->input->post('vdo_clips_link');
            $data['update_by']           = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['update_date'] = date("Y-m-d H:i:s");
            $this->crud_model->file_up("images", "vdo_clips", $para2, '');
            $this->db->where('id', $para2);
            $this->db->update('vdo_clips', $data);
            redirect(base_url() . 'index.php/admin/vdo_clips/', 'refresh');
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('vdo_clips', $para2, '.jpg', '');
            $this->db->where('id', $para2);
            $this->db->delete('vdo_clips');
            redirect(base_url() . 'index.php/admin/vdo_clips/', 'refresh');
        } elseif ($para1 == 'list') {
            $this->db->order_by('id', 'desc');
            $page_data['all_activity'] = $this->db->get('vdo_clips')->result_array();
            $this->load->view('back/admin/vdo_clips_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/vdo_clips_add');
        } else {
            $page_data['page_name']      = "vdo_clips";
            $page_data['all_activity'] = $this->db->get('vdo_clips')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
     /*health_corner*/
    function health_corner($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('health_corner')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['corner_name'] = $this->input->post('corner_name');
            $data['corner_name_en'] = $this->input->post('corner_name_en');
            $data['corner_detail'] = $this->input->post('corner_detail');
            $data['corner_detail_en'] = $this->input->post('corner_detail_en');
            $data['create_by']   = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['create_date'] = date("Y-m-d H:i:s");
            $this->db->insert('health_corner', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("images", "health_corner", $id, '');
            redirect(base_url() . 'index.php/admin/health_corner/', 'refresh');
        } else if ($para1 == 'edit') {
            $page_data['corner_data'] = $this->db->get_where('health_corner', array(
                'id' => $para2
            ))->result_array();
            $this->load->view('back/admin/health_corner_edit', $page_data);

        } elseif ($para1 == "update") {

            $data['corner_name'] = $this->input->post('corner_name');
            $data['corner_name_en'] = $this->input->post('corner_name_en');
            $data['corner_detail'] = $this->input->post('corner_detail');
            $data['corner_detail_en'] = $this->input->post('corner_detail_en');
            $data['update_by']           = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['update_date'] = date("Y-m-d H:i:s");
            $this->crud_model->file_up("images", "health_corner", $para2, '');
            $this->db->where('id', $para2);
            $this->db->update('health_corner', $data);
            redirect(base_url() . 'index.php/admin/health_corner/', 'refresh');
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('health_corner', $para2, '.jpg', '');
            $this->db->where('id', $para2);
            $this->db->delete('health_corner');
            redirect(base_url() . 'index.php/admin/health_corner/', 'refresh');
        } elseif ($para1 == 'list') {
            $this->db->order_by('id', 'desc');
            $page_data['all_corner'] = $this->db->get('health_corner')->result_array();
            $this->load->view('back/admin/health_corner_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/health_corner_add');
        } else {
            $page_data['page_name']      = "health_corner";
            $page_data['all_corner'] = $this->db->get('health_corner')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }

    function partners($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('partners')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['partners_name'] = $this->input->post('partners_name');
            $data['partners_name_en'] = $this->input->post('partners_name_en');
            $data['partners_detail'] = $this->input->post('partners_detail');
            $data['partners_detail_en'] = $this->input->post('partners_detail_en');
            $data['partners_link'] = $this->input->post('partners_link');
            $data['create_by']   = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['create_date'] = date("Y-m-d H:i:s");
            $this->db->insert('partners', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("images", "partners", $id, '');
            redirect(base_url() . 'index.php/admin/partners/', 'refresh');
        } else if ($para1 == 'edit') {
            $page_data['partners_data'] = $this->db->get_where('partners', array(
                'partners_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/partners_edit', $page_data);

        } elseif ($para1 == "update") {

            $data['partners_name'] = $this->input->post('partners_name');
            $data['partners_name_en'] = $this->input->post('partners_name_en');
            $data['partners_detail'] = $this->input->post('partners_detail');
            $data['partners_detail_en'] = $this->input->post('partners_detail_en');
            $data['partners_link'] = $this->input->post('partners_link');
            $data['update_by']           = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['update_date'] = date("Y-m-d H:i:s");
            $this->crud_model->file_up("images", "partners", $para2, '');
            $this->db->where('partners_id', $para2);
            $this->db->update('partners', $data);
            redirect(base_url() . 'index.php/admin/partners/', 'refresh');
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('partners', $para2, '.jpg', '');
            $this->db->where('partners_id', $para2);
            $this->db->delete('partners');
            exit();
            redirect(base_url() . 'index.php/admin/partners/', 'refresh');
        } elseif ($para1 == 'list') {
            $this->db->order_by('partners_id', 'desc');
            $page_data['all_partners'] = $this->db->get('partners')->result_array();
            $this->load->view('back/admin/partners_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/partners_add');
        } else {
            $page_data['page_name']      = "partners";
            $page_data['all_partners'] = $this->db->get('partners')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }

    function where_to_buy($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('where_to_buy')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['where_to_buy_name'] = $this->input->post('where_to_buy_name');
            $data['where_to_buy_name_en'] = $this->input->post('where_to_buy_name_en');
            $data['where_to_buy_detail'] = $this->input->post('where_to_buy_detail');
            $data['where_to_buy_detail_en'] = $this->input->post('where_to_buy_detail_en');
            $data['where_to_buy_link'] = $this->input->post('where_to_buy_link');
            $data['create_by']   = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['create_date'] = date("Y-m-d H:i:s");
            $this->db->insert('where_to_buy', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("images", "where_to_buy", $id, '');
            redirect(base_url() . 'index.php/admin/where_to_buy/', 'refresh');
        } else if ($para1 == 'edit') {
            $page_data['where_to_buy_data'] = $this->db->get_where('where_to_buy', array(
                'where_to_buy_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/where_to_buy_edit', $page_data);

        } elseif ($para1 == "update") {

            $data['where_to_buy_name'] = $this->input->post('where_to_buy_name');
            $data['where_to_buy_name_en'] = $this->input->post('where_to_buy_name_en');
            $data['where_to_buy_detail'] = $this->input->post('where_to_buy_detail');
            $data['where_to_buy_detail_en'] = $this->input->post('where_to_buy_detail_en');
            $data['where_to_buy_link'] = $this->input->post('where_to_buy_link');
            $data['update_by']           = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['update_date'] = date("Y-m-d H:i:s");
            $this->crud_model->file_up("images", "where_to_buy", $para2, '');
            $this->db->where('where_to_buy_id', $para2);
            $this->db->update('where_to_buy', $data);
            redirect(base_url() . 'index.php/admin/where_to_buy/', 'refresh');
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('where_to_buy', $para2, '.jpg', '');
            $this->db->where('where_to_buy_id', $para2);
            $this->db->delete('where_to_buy');
            exit();
            redirect(base_url() . 'index.php/admin/where_to_buy/', 'refresh');
        } elseif ($para1 == 'list') {
            $this->db->order_by('where_to_buy_id', 'desc');
            $page_data['all_where_to_buy'] = $this->db->get('where_to_buy')->result_array();
            $this->load->view('back/admin/where_to_buy_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/where_to_buy_add');
        } else {
            $page_data['page_name']      = "where_to_buy";
            $page_data['all_where_to_buy'] = $this->db->get('where_to_buy')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Manage founder */
    function founder($para1 = "")
    {
        if (!$this->crud_model->admin_permission('seo')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "set") {
            $this->crud_model->file_up("pic", "founder", 'image','');          
            $this->db->where('type', "firstname");
            $this->db->update('founder', array(
                'value' => $this->input->post('firstname'),
                'value_en' => $this->input->post('firstname_en')
            ));
            $this->db->where('type', "lastname");
            $this->db->update('founder', array(
                'value' => $this->input->post('lastname'),
                'value_en' => $this->input->post('lastname_en')
            ));
            

        }
        else {
            require_once (APPPATH . 'libraries/SEOstats/bootstrap.php');
            $page_data['page_name'] = "founder";
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*founder_message*/
    function founder_message($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('founder_message')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['message_title'] = $this->input->post('message_title');
            $data['message_detail'] = $this->input->post('message_detail');
            $data['message_title_en'] = $this->input->post('message_title_en');
            $data['message_detail_en'] = $this->input->post('message_detail_en');
            $data['create_by']   = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['create_date'] = date("Y-m-d H:i:s");
            $this->db->insert('founder_message', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("images", "founder_message", $id, '');
            redirect(base_url() . 'index.php/admin/founder_message/', 'refresh');
        } else if ($para1 == 'edit') {
            $page_data['message_data'] = $this->db->get_where('founder_message', array(
                'id' => $para2
            ))->result_array();
            $this->load->view('back/admin/founder_message_edit', $page_data);

        } elseif ($para1 == "update") {
            $data['message_title'] = $this->input->post('message_title');
            $data['message_detail'] = $this->input->post('message_detail');
            $data['message_title_en'] = $this->input->post('message_title_en');
            $data['message_detail_en'] = $this->input->post('message_detail_en');
            $data['update_by']           = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['update_date'] = date("Y-m-d H:i:s");
            $this->crud_model->file_up("images", "founder_message", $para2, '');
            $this->db->where('id', $para2);
            $this->db->update('founder_message', $data);
            redirect(base_url() . 'index.php/admin/founder_message/', 'refresh');
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('founder_message', $para2, '.jpg', '');
            $this->db->where('id', $para2);
            $this->db->delete('founder_message');
            redirect(base_url() . 'index.php/admin/founder_message/', 'refresh');
        } elseif ($para1 == 'list') {
            $this->db->order_by('id', 'desc');
            $page_data['all_message'] = $this->db->get('founder_message')->result_array();
            $this->load->view('back/admin/founder_message_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/founder_message_add');
        } else {
            $page_data['page_name']      = "founder_message";
            $page_data['all_message'] = $this->db->get('founder_message')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }

    function intro($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('intro')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['intro_title'] = $this->input->post('intro_title');
            $data['create_by']   = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['create_date'] = date("Y-m-d H:i:s");
            $this->db->insert('intro', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("images", "intro", $id, '');
            $this->crud_model->file_up("backgroundimages", "backgroundintro", $id, '');
            redirect(base_url() . 'index.php/admin/intro/', 'refresh');
        } elseif ($para1 == 'intro_publish_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('id', $product);
            $this->db->update('intro', $data);
        } else if ($para1 == 'edit') {
            $page_data['message_data'] = $this->db->get_where('intro', array(
                'id' => $para2
            ))->result_array();
            $this->load->view('back/admin/intro_edit', $page_data);

        } elseif ($para1 == "update") {
            $data['intro_title'] = $this->input->post('intro_title');
            $data['update_by']           = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $data['update_date'] = date("Y-m-d H:i:s");
            $this->crud_model->file_up("images", "intro", $para2, '');
            $this->crud_model->file_up("backgroundimages", "backgroundintro", $para2, '');
            $this->db->where('id', $para2);
            $this->db->update('intro', $data);
            redirect(base_url() . 'index.php/admin/intro/', 'refresh');
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('intro', $para2, '.jpg', '');
            $this->db->where('id', $para2);
            $this->db->delete('intro');
            redirect(base_url() . 'index.php/admin/intro/', 'refresh');
        } elseif ($para1 == 'list') {
            $this->db->order_by('id', 'desc');
            $page_data['all_message'] = $this->db->get('intro')->result_array();
            $this->load->view('back/admin/intro_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/intro_add');
        } else {
            $page_data['page_name']      = "intro";
            $page_data['all_message'] = $this->db->get('intro')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*about_us*/
    function about_us($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('about_us')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "set") {                 
            $this->crud_model->file_up("images", "about_us", 'image','');
            $this->db->where('type', "detail");
            $this->db->update('about_us', array(
                'value' => $this->input->post('detail'),
                'value_en' => $this->input->post('detail_en')
            ));

        } else {
            require_once (APPPATH . 'libraries/SEOstats/bootstrap.php');
            $page_data['page_name'] = "about_us";
            $this->load->view('back/index', $page_data);
        }
    }

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */