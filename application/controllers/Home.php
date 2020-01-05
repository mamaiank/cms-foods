<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller
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
        $this->load->database();
        $this->load->library('paypal');
        /*cache control*/
        $cache_time = $this->db->get_where('general_settings', array('type' => 'cache_time'))->row()->value;
        if (!$this->input->is_ajax_request()) {
            $this->output->set_header('HTTP/1.0 200 OK');
            $this->output->set_header('HTTP/1.1 200 OK');
            $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
            $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
            $this->output->set_header('Cache-Control: post-check=0, pre-check=0');
            $this->output->set_header('Pragma: no-cache');
            $this->output->cache($cache_time);
        }
        $this->crud_model->ip_data();

        //Your code:
        if( ! $this->session->userdata('language') ){
            $this->session->set_userdata('language','Thai');
        }
        $rand =rand(0,20);
        if($rand == 0){
            $this->session->set_userdata('intro',false);
        }
        $intro = $this->db->get_where('intro',array('status'=>'ok'))->row();
        if(!$this->session->userdata('intro') && $intro){
            $page_data['page_name'] = "intro";
            $this->session->set_userdata('intro',true);
            redirect(base_url() . 'index.php/home/indexintro/', 'refresh');
        }
    }

    public function indexintro()
    {
        $this->load->view('front/intro');
    }

    /* FUNCTION: Loads Homepage*/
    public function index($intro=null)
    {
        if($intro != null){
            $this->session->set_userdata('language', $intro);
        }
        $page_data['page_name'] = "home";
        $page_data['header_active'] = "Home";
        $page_data['page_title'] = translate('home');
        $this->load->view('front/index', $page_data);
    }

    public function about()
    {
        $page_data['content'] = $this->db->get('about_us')->row();
        $page_data['page_name'] = "about";
        $page_data['header_active'] = "About";
        $page_data['page_title'] = translate('about us');
        $this->load->view('front/index', $page_data);
    }

    public function spafoods($sub,$offset = 0)
    {
        $this->load->model('Product_model');
        $array = $this->Product_model->get_all_spa($offset,'10','/home/spafoods',$sub);
        $page_data['content'] = $this->db->get_where('sub_category',array('sub_category_id'=>$sub))->row();
        $page_data['query'] = $array['query'];
        $page_data['pagination'] = $array['pagination'];
        $page_data['page_name'] = "spafoods";
        $active = $this->db->get_where('category',array('category_id'=>$page_data['content']->category))->row();
        $active = str_replace(" ","",$active->category_name);
        $active = str_replace(".","",$active);
        $page_data['header_active'] = $active;
        $page_data['page_title'] = translate('spafoods');
        $this->load->view('front/index', $page_data);
    }

    public function spafood_detail($sub,$id)
    {
        $page_data['content'] = $this->db->get_where('product',array('sub_category'=>$sub,'product_id'=>$id))->row();
        $sub_cat = $this->db->get_where('sub_category',array('sub_category_id'=>$sub))->row();
        $page_data['page_name'] = "spafood-detail";
        $page_data['title'] = $this->nookcs_model->getDataMultiLanguage($sub_cat->sub_category_name,$sub_cat->sub_category_name_en);
        $active = $this->db->get_where('category',array('category_id'=>$page_data['content']->category))->row();
        $active = str_replace(" ","",$active->category_name);
        $active = str_replace(".","",$active);
        $page_data['header_active'] = $active;
        $page_data['page_title'] = translate('spafood-detail');
        $this->load->view('front/index', $page_data);
    }

    public function jv_product()
    {
        $page_data['page_name'] = "jv-product";
        $page_data['header_active'] = "JV";
        $page_data['page_title'] = translate('jv-product');
        $this->load->view('front/index', $page_data);
    }

    public function jvproduct_detail()
    {
        $page_data['page_name'] = "jvproduct-detail";
        $page_data['header_active'] = "JV";
        $page_data['page_title'] = translate('jvproduct-detail');
        $this->load->view('front/index', $page_data);
    }

    public function restaurant_overview()
    {
        $page_data['restaurants_service_detail'] = $this->db->get_where('general_settings',array('type'=>'restaurants_service_detail'))->row()->value;
        $page_data['restaurants_service_pic_detail'] = $this->db->get_where('general_settings',array('type'=>'restaurants_service_pic_detail'))->row()->value;
        $page_data['restaurants_service_detail_en'] = $this->db->get_where('general_settings',array('type'=>'restaurants_service_detail_en'))->row()->value;
        $page_data['restaurants_service_pic_detail_en'] = $this->db->get_where('general_settings',array('type'=>'restaurants_service_pic_detail_en'))->row()->value;
        $page_data['restaurants_service_phone'] = $this->db->get_where('general_settings',array('type'=>'restaurants_service_phone'))->row()->value;
        $page_data['restaurants_service_tel'] = $this->db->get_where('general_settings',array('type'=>'restaurants_service_tel'))->row()->value;
        $page_data['page_name'] = "restaurant-overview";
        $page_data['header_active'] = "Restaurant";
        $page_data['page_title'] = translate('restaurant_&_services');
        $this->load->view('front/index', $page_data);
    }

    public function restaurant_detail($id)
    {
        $page_data['content'] = $this->db->get_where('store_locations',array('id'=>$id))->row();
        $page_data['page_name'] = "restaurant-detail";
        $page_data['header_active'] = "Restaurant";
        $page_data['page_title'] = translate('the-vegetarian-cottage');
        $this->load->view('front/index', $page_data);
    }

    public function recommended_menus()
    {
        $page_data['page_name'] = "recommended-menus";
        $page_data['header_active'] = "Restaurant";
        $page_data['page_title'] = translate('recommended-menus');
        $this->load->view('front/index', $page_data);
    }

    public function recommended_menus_detail($id)
    {
        $page_data['content'] = $this->db->get_where('recommended_menus',array('id'=>$id))->row();
        $page_data['page_name'] = "recommended-menus-detail";
        $page_data['header_active'] = "Restaurant";
        $page_data['page_title'] = translate('recommended_menus');
        $this->load->view('front/index', $page_data);
    }

    public function news_event($offset = 0)
    {
        $this->load->model('Product_model');
        $array = $this->Product_model->get_all_news($offset,'12','/home/news_event');
        $page_data['query'] = $array['query'];
        $page_data['pagination'] = $array['pagination'];
        $page_data['page_name'] = "news-event";
        $page_data['header_active'] = "News";
        $page_data['page_title'] = translate('News & Events');
        $this->load->view('front/index', $page_data);
    }

    public function news_event_detail($id)
    {
        $page_data['content'] = $this->db->get_where('event_activity',array('id'=>$id))->row();
        $page_data['page_name'] = "news-event-detail";
        $page_data['header_active'] = "News";
        $page_data['page_title'] = translate('News & Events');
        $this->load->view('front/index', $page_data);
    }

    public function vdo_clips($offset = 0)
    {
        $this->load->model('Product_model');
        $array = $this->Product_model->get_all_vdo($offset,'8','/home/vdo_clips');
        $page_data['query'] = $array['query'];
        $page_data['pagination'] = $array['pagination'];
        $page_data['page_name'] = "vdo-clips";
        $page_data['header_active'] = "News";
        $page_data['page_title'] = translate('Vdo_Clips');
        $this->load->view('front/index', $page_data);
    }

    public function vdoclips_detail($id)
    {
        $page_data['content'] = $this->db->get_where('vdo_clips',array('id'=>$id))->row();
        $page_data['page_name'] = "vdoclips-detail";
        $page_data['header_active'] = "News";
        $page_data['page_title'] = translate('Vdo_Clips');
        $this->load->view('front/index', $page_data);
    }

    public function health($offset = 0)
    {
        $this->load->model('Product_model');
        $array = $this->Product_model->get_all_health($offset,'12','/home/health');
        $page_data['query'] = $array['query'];
        $page_data['pagination'] = $array['pagination'];
        $page_data['page_name'] = "health";
        $page_data['header_active'] = "Health";
        $page_data['page_title'] = translate('HEALTH CORNER');
        $this->load->view('front/index', $page_data);
    }

    public function health_detail($id)
    {
        $page_data['content'] = $this->db->get_where('health_corner',array('id'=>$id))->row();
        $page_data['page_name'] = "health-detail";
        $page_data['header_active'] = "Health";
        $page_data['page_title'] = translate('HEALTH CORNER');
        $this->load->view('front/index', $page_data);
    }

    public function founder()
    {
        $this->db->order_by('id', 'asc');
        $page_data['all_message'] = $this->db->get('founder_message')->result_array();
        $page_data['page_name'] = "founder";
        $page_data['header_active'] = "Founder";
        $page_data['page_title'] = translate('MESSAGE FROM FOUNDER');
        $this->load->view('front/index', $page_data);
    }

    public function founder_detail($id)
    {
        $page_data['content'] = $this->db->get_where('founder_message',array('id'=>$id))->row();
        $page_data['page_name'] = "founder-detail";
        $page_data['header_active'] = "Founder";
        $page_data['page_title'] = translate('MESSAGE FROM FOUNDER');
        $this->load->view('front/index', $page_data);
    }

    public function our_partners()
    {
        $page_data['content'] = $this->db->get_where('partners',array('acive'=>'y'))->result_array();
        $page_data['page_name'] = "our-partners";
        $page_data['page_title'] = translate('Our Partners');
        $this->load->view('front/index', $page_data);
    }

    public function wheretobuy()
    {
        $page_data['content'] = $this->db->get_where('where_to_buy',array('acive'=>'y'))->result_array();
        $page_data['page_name'] = "wheretobuy";
        $page_data['page_title'] = translate('Where to buy');
        $this->load->view('front/index', $page_data);
    }

    public function downloadfile()
    {
        $page_data['page_name'] = "downloadfile";
        $page_data['page_title'] = translate('downloadfile');
        $this->load->view('front/index', $page_data);
    }


    /* FUNCTION: Loads Contact Page */
    function contact($para1 = "")
    {
        // reCAPTCHA secret key
        define('SecretKey', "6LcaUyEUAAAAAGYldcO-0HaPcpCMTAIZ_9AqQmF_");

        $this->load->library('recaptcha');
        $this->load->library('form_validation');

        if ($para1 == 'send') {
            $safe = 'yes';
            $char = '';
            foreach ($_POST as $row) {
                if (preg_match('/[\'^":()}{#~><>|=+¬]/', $row, $match)) {
                    $safe = 'no';
                    $char = $match[0];
                }
            }


            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('subject', 'Subject', 'required');
            $this->form_validation->set_rules('message', 'Message', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');

            if ($this->form_validation->run() == FALSE) {
                $_SESSION['FLASH']='validation_error';
                redirect(base_url() . 'index.php/home/contact/', 'refresh');
                echo validation_errors();
            } else {
                if ($safe == 'yes') {

                    $query_params = array(
                        'secret' => SecretKey,
                        'response' => filter_input(INPUT_POST, 'g-recaptcha-response'),
                        'remoteip' => $_SERVER['REMOTE_ADDR']
                    );
                    $url = 'https://www.google.com/recaptcha/api/siteverify?'.http_build_query($query_params);
                    $result = json_decode(file_get_contents($url), true);

                   $this->recaptcha->recaptcha_check_answer();
                    if ($result['success']) {
                        $data['name'] = $this->input->post('name', true);
                        $data['subject'] = $this->input->post('subject');
                        $data['email'] = $this->input->post('email');
                        $data['tel'] = $this->input->post('tel');
                        $data['message'] = $this->security->xss_clean(($this->input->post('message')));
                        $data['view'] = 'no';
                        $data['timestamp'] = time();
                        $this->db->insert('contact_message', $data);
                        $_SESSION['FLASH']='sent';
                        redirect(base_url() . 'index.php/home/contact/', 'refresh');
                        echo 'sent';
                    } else {
                        $_SESSION['FLASH']='recaptcha_error';
                        redirect(base_url() . 'index.php/home/contact/', 'refresh');
                        echo "ฉันไม่ใช่โปรแกรมอัตโนมัติ";
                    }
                } else {
                    echo 'Disallowed charecter : " ' . $char . ' " in the POST';
                }
            }
        } else {
            // $page_data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
            $page_data['page_name'] = "contact";
            $page_data['header_active'] = "Contact";
            $page_data['page_title'] = translate('contact');
            $this->load->view('front/index', $page_data);
        }
    }

    function vendor($vendor_id)
    {
        $vendor_system = $this->db->get_where('general_settings', array('type' => 'vendor_system'))->row()->value;
        if ($vendor_system == 'ok' &&
            $this->db->get_where('vendor', array('vendor_id' => $vendor_id))->row()->status == 'approved'
        ) {
            $min = $this->get_range_lvl('added_by', '{"type":"vendor","id":"' . $vendor_id . '"}', "min");
            $max = $this->get_range_lvl('added_by', '{"type":"vendor","id":"' . $vendor_id . '"}', "max");
            $this->db->order_by('product_id', 'desc');
            $page_data['featured_data'] = $this->db->get_where('product', array(
                'featured' => "ok",
                'status' => 'ok',
                'added_by' => '{"type":"vendor","id":"' . $vendor_id . '"}'
            ))->result_array();
            $page_data['range'] = $min . ';' . $max;
            $page_data['all_category'] = $this->db->get('category')->result_array();
            $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();
            $page_data['page_name'] = 'vendor_home';
            $page_data['vendor'] = $vendor_id;
            $page_data['page_title'] = $this->db->get_where('vendor', array('vendor_id' => $vendor_id))->row()->display_name;
            $this->load->view('front/index', $page_data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }


    /* FUNCTION: Loads Customer Profile Page */
    function profile()
    {
        if ($this->session->userdata('user_login') != "yes") {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name'] = "profile";
        $page_data['page_title'] = translate('my_profile');
        $page_data['all_products'] = $this->db->get_where('user', array(
            'user_id' => $this->session->userdata('user_id')
        ))->result_array();
        $page_data['user_info'] = $this->db->get_where('user', array(
            'user_id' => $this->session->userdata('user_id')
        ))->result_array();

        $this->load->view('front/index', $page_data);
    }

    /* FUNCTION: Loads Category filter page */
    function category($para1 = "", $para2 = "", $min = "", $max = "")
    {

        if ($para2 == "") {
            $page_data['all_products'] = $this->db->get_where('product', array(
                'category' => $para1
            ))->result_array();
        } else if ($para2 != "") {
            $page_data['all_products'] = $this->db->get_where('product', array(
                'sub_category' => $para2
            ))->result_array();
        }
        $page_data['range'] = $min . ';' . $max;
        $page_data['page_name'] = "product_list";
        $page_data['page_title'] = translate('products');
        $page_data['all_category'] = $this->db->get('category')->result_array();
        $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();
        $page_data['cur_sub_category'] = $para2;
        $page_data['cur_category'] = $para1;
        $page_data['category_data'] = $this->db->get_where('category', array(
            'category_id' => $para1
        ))->result_array();
        $this->load->view('front/index', $page_data);
    }


    /* FUNCTION: Search Products */
    function home_search($param = '')
    {
        $category = $this->input->post('category');
        $this->session->set_userdata('searched_cat', $category);
        if ($param !== 'top') {
            $sub_category = $this->input->post('sub_category');
            $range = $this->input->post('range');
            $p = explode(';', $range);
            redirect(base_url() . 'index.php/home/category/' . $category . '/' . $sub_category . '/' . $p[0] . '/' . $p[1], 'refresh');
        } else if ($param == 'top') {
            redirect(base_url() . 'index.php/home/category/' . $category, 'refresh');
        }
    }


    /* FUNCTION: Search Products */
    function search()
    {
        $page_data['page_name'] = "search";
        $page_data['page_title'] = translate('search_products');
        $page_data['all_category'] = $this->db->get('category')->result_array();
        $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();
        $this->load->view('front/index', $page_data);
    }


    /* FUNCTION: Check if user logged in */
    function is_logged()
    {
        if ($this->session->userdata('user_login') == 'yes') {
            echo 'yah!good';
        } else {
            echo 'nope!bad';
        }
    }

    /* FUNCTION: Loads Product List */
    function listed($para1 = "", $para2 = "", $para3 = "")
    {
        $this->load->library('Ajax_pagination');
        if ($para1 == "click") {
            if ($this->input->post('range')) {
                $range = $this->input->post('range');
            }
            $category = $this->input->post('category');
            $category = explode(',', $category);
            $sub_category = $this->input->post('sub_category');
            $sub_category = explode(',', $sub_category);
            $featured = $this->input->post('featured');
            $promotion = $this->input->post('promotion');
            $chk_search = $this->input->post('chk_search');
            $text_search = $this->input->post('text_search');

            $brand = $this->input->post('brand');
            $brand_id = $this->input->post('brand_id');

            $name = '';
            $cat = '';
            $setter = '';
            $vendors = array();
            $approved_users = $this->db->get_where('vendor', array('status' => 'approved'))->result_array();
            foreach ($approved_users as $row) {
                $vendors[] = $row['vendor_id'];
            }


            if ($vendor = $this->input->post('vendor')) {
                if (in_array($vendor, $vendors)) {
                    $this->db->where('added_by', '{"type":"vendor","id":"' . $vendor . '"}');
                } else {
                    $this->db->where('product_id', '');
                }
            }

            $this->db->where('status', 'ok');
            if ($featured == 'ok') {
                $this->db->where('featured', 'ok');
                $name = 'Featured';
            }
            if ($promotion == 'ok') {
                $this->db->where('promotion', 'ok');
                $name = 'Promotion';
            }
            if ($brand == 'ok') {
                $this->db->where('brand', $brand_id);
                $name = 'Brand';
            }

            if ($brand == 'ok') {
                $this->db->where('brand', $brand_id);
                $name = 'Brand';
            }
            if ($chk_search == 'ok') {
                $this->db->like('title', $text_search);
                $name = $text_search;
            }


            if (isset($range)) {
                $p = explode(';', $range);
                $this->db->where('sale_price >=', $p[0]);
                $this->db->where('sale_price <=', $p[1]);
            }

            $query = array();
            if (count($sub_category) > 0) {
                $i = 0;
                foreach ($sub_category as $row) {
                    $i++;
                    if ($row !== "") {
                        if ($row !== "0") {
                            $query[] = $row;
                            $setter = 'get';
                        } else {
                            $this->db->where('sub_category !=', '0');
                        }
                    }
                }
                if ($setter == 'get') {
                    $this->db->where_in('sub_category', $query);
                }
            }

            if (count($category) > 0 && $setter !== 'get') {
                $i = 0;
                foreach ($category as $row) {
                    $i++;
                    if ($row !== "") {
                        if ($row !== "0") {
                            if ($i == 1) {
                                $this->db->where('category', $row);
                            } else {
                                $this->db->or_where('category', $row);
                            }
                        } else {
                            $this->db->where('category !=', '0');
                        }
                    }
                }
            }
            $this->db->order_by('product_id', 'desc');

            // pagination
            $config['total_rows'] = $this->db->count_all_results('product');
            $config['base_url'] = base_url() . 'index.php?home/listed/';
            if ($featured !== 'ok') {
                $config['per_page'] = 12;
            } else if ($featured == 'ok') {
                $config['per_page'] = 12;
            }else if ($promotion == 'ok'){
                $config['per_page'] = 12;
            }
            $config['uri_segment'] = 5;
            $config['cur_page_giv'] = $para2;

            $function = "filter('click','none','none','0')";
            $config['first_link'] = '&laquo;';
            $config['first_tag_open'] = '<a rel="grow" class="btn-u btn-u-sea grow" onClick="' . $function . '">';
            $config['first_tag_close'] = '</a>';

            $rr = ($config['total_rows'] - 1) / $config['per_page'];
            $last_start = floor($rr) * $config['per_page'];
            $function = "filter('click','none','none','" . $last_start . "')";
            $config['last_link'] = '&raquo;';
            $config['last_tag_open'] = '<a rel="grow" class="btn-u btn-u-sea grow" onClick="' . $function . '">';
            $config['last_tag_close'] = '</a>';

            $function = "filter('click','none','none','" . ($para2 - $config['per_page']) . "')";
            $config['prev_tag_open'] = '<a rel="grow" class="btn-u btn-u-sea grow" onClick="' . $function . '">';
            $config['prev_tag_close'] = '</a>';

            $function = "filter('click','none','none','" . ($para2 + $config['per_page']) . "')";
            $config['next_link'] = '&rsaquo;';
            $config['next_tag_open'] = '<a rel="grow" class="btn-u btn-u-sea grow" onClick="' . $function . '">';
            $config['next_tag_close'] = '</a>';

            $config['full_tag_open'] = '<ul class="pagination pagination-v2">';
            $config['full_tag_close'] = '</ul>';

            $config['cur_tag_open'] = '<a rel="grow" class="btn-u btn-u-red grow" class="active">';
            $config['cur_tag_close'] = '</a>';

            $function = "filter('click','none','none',((this.innerHTML-1)*" . $config['per_page'] . "))";
            $config['num_tag_open'] = '<a rel="grow" class="btn-u btn-u-sea grow" onClick="' . $function . '">';
            $config['num_tag_close'] = '</a>';
            $this->ajax_pagination->initialize($config);


            $this->db->where('status', 'ok');
            if ($featured == 'ok') {
                $this->db->where('featured', 'ok');
                $grid_items_per_row = 3;
                $name = 'Featured';
            } elseif ($promotion == 'ok') {
                $this->db->where('promotion', 'ok');
                $grid_items_per_row = 3;
                $name = 'Promotion';
            }elseif ($brand == 'ok') {
                $this->db->where('brand', $brand_id);
                $grid_items_per_row = 3;
                $name = 'Brand';
            }elseif ($chk_search == 'ok'){
                $this->db->like('title', $text_search);
                $grid_items_per_row = 3;
                $name = $text_search;
            }else{
                $grid_items_per_row = 3;
            }


            if ($vendor = $this->input->post('vendor')) {
                if (in_array($vendor, $vendors)) {
                    $this->db->where('added_by', '{"type":"vendor","id":"' . $vendor . '"}');
                } else {
                    $this->db->where('product_id', '');
                }
            }

            if (isset($range)) {
                $p = explode(';', $range);
                $this->db->where('sale_price >=', $p[0]);
                $this->db->where('sale_price <=', $p[1]);
            }

            $query = array();
            if (count($sub_category) > 0) {
                $i = 0;
                foreach ($sub_category as $row) {
                    $i++;
                    if ($row !== "") {
                        if ($row !== "0") {
                            $query[] = $row;
                            $setter = 'get';
                        } else {
                            $this->db->where('sub_category !=', '0');
                        }
                    }
                }
                if ($setter == 'get') {
                    $this->db->where_in('sub_category', $query);
                }
            }

            if (count($category) > 0 && $setter !== 'get') {
                $i = 0;
                foreach ($category as $rowc) {
                    $i++;
                    if ($rowc !== "") {
                        if ($rowc !== "0") {
                            if ($i == 1) {
                                $this->db->where('category', $rowc);
                            } else {
                                $this->db->or_where('category', $rowc);
                            }
                        } else {
                            $this->db->where('category !=', '0');
                        }
                    }
                }
            }


            $this->db->order_by('product_id', 'desc');
            $page_data['all_products'] = $this->db->get('product', $config['per_page'], $para2)->result_array();

            if ($name != '') {
                $name .= ' : ';
            }
            if (isset($rowc)) {
                $cat = $rowc;
            } else {
                if ($setter == 'get') {
                    $cat = $this->crud_model->get_type_name_by_id('sub_category', $sub_category[0], 'category');
                }
            }
            if ($cat !== '') {
                if ($cat !== '0') {
                    $name .= $this->crud_model->get_type_name_by_id('category', $cat, 'category_name');
                } else {
                    $name = 'All Products';
                }
            }

        } elseif ($para1 == "load") {
            $page_data['all_products'] = $this->db->get('product')->result_array();
        }
        $page_data['vendor_system'] = $this->db->get_where('general_settings', array('type' => 'vendor_system'))->row()->value;
        $page_data['category_data'] = $category;
        $page_data['viewtype'] = $para3;
        $page_data['name'] = $name;
        $page_data['count'] = $config['total_rows'];
        $page_data['grid_items_per_row'] = $grid_items_per_row;
        $this->load->view('front/listed', $page_data);
    }

    /* FUNCTION: Loads Featured Product Page */
    function featured_item($min = '', $max = '')
    {
        $page_data['page_name'] = "featured_list";
        $page_data['page_title'] = translate('featured_products');
        $page_data['range'] = $min . ';' . $max;
        $page_data['all_category'] = $this->db->get('category')->result_array();
        $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();
        $page_data['all_products'] = $this->db->get_where('product', array(
            'featured' => "ok",
            'status' => 'ok'
        ))->result_array();
        $this->load->view('front/index', $page_data);
    }

    /* FUNCTION: Loads Featured Product Page */
    function promotion_item($min = '', $max = '')
    {
        $page_data['page_name'] = "promotion";
        $page_data['page_title'] = translate('promotion_products');
        $page_data['range'] = $min . ';' . $max;
        $page_data['all_category'] = $this->db->get('category')->result_array();
        $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();
        $page_data['all_products'] = $this->db->get_where('product', array(
            'promotion' => "ok",
            'status' => 'ok'
        ))->result_array();
        $this->load->view('front/index', $page_data);
    }


    /* FUNCTION: Loads Featured Product Page */
    function brand_item($para1 = "",$min = '', $max = '')
    {
        $page_data['page_name'] = "brand_list";
        $page_data['page_title'] = translate('brand_products');
        $page_data['range'] = $min . ';' . $max;
        $page_data['all_category'] = $this->db->get('category')->result_array();
        $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();
        $page_data['brand'] = $para1;
        $this->load->view('front/index', $page_data);
    }

    /* FUNCTION: Loads Custom Pages */
    function page($parmalink = '')
    {

        $pagef = $this->db->get_where('page', array(
            'parmalink' => $parmalink
        ));
//        var_dump($this->session->userdata('admin_login'));
//        exit();
        $page_data['page_name'] = "page";
        $page_data['page_title'] = $parmalink;
        $page_data['page_items'] = $pagef->result_array();
//        if ($this->session->userdata('admin_login') !== 'yes' && $pagef->row()->status !== 'ok') {
//            redirect(base_url() . 'index.php/home/', 'refresh');
//        }
        $this->load->view('front/index', $page_data);
    }


    /* FUNCTION: Loads Product View Page */
    function product_view($para1 = "")
    {
        $page_data['page_name'] = "product_view";
        $product_data = $this->db->get_where('product', array(
            'product_id' => $para1,
            'status' => 'ok'
        ));
        $page_data['product_data'] = $product_data->result_array();
        $page_data['page_title'] = $product_data->row()->title;
        $page_data['product_tags'] = $product_data->row()->tag;

        $this->load->view('front/index', $page_data);
    }

    /* FUNCTION: Setting Frontend Language */
    function set_language($lang)
    {
        $this->session->set_userdata('language', $lang);
        $page_data['page_name'] = "home";
        redirect(base_url() . 'index.php/home/', 'refresh');
    }

    /* FUNCTION: Concerning Login */
    function vendor_logup($para1 = "", $para2 = "")
    {
        if ($para1 == "add_info") {
            $this->load->library('form_validation');
            $safe = 'yes';
            $char = '';
            foreach ($_POST as $k => $row) {
                if (preg_match('/[\'^":()}{#~><>|=+¬]/', $row, $match)) {
                    if ($k !== 'password1' && $k !== 'password2') {
                        $safe = 'no';
                        $char = $match[0];
                    }
                }
            }

            $this->form_validation->set_rules('name', 'Your First Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'valid_email|required|is_unique[vendor.email]', array('required' => 'You have not provided %s.', 'is_unique' => 'This %s already exists.'));
            $this->form_validation->set_rules('password1', 'Password', 'required');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'required');
            $this->form_validation->set_rules('address1', 'Address Line 1', 'required');
//            $this->form_validation->set_rules('address2', 'Address Line 2', 'required');
            $this->form_validation->set_rules('display_name', 'Your Display Name', 'required');

            if ($this->form_validation->run() == FALSE) {
                echo validation_errors();
            } else {
                if ($safe == 'yes') {
                    $data['name'] = $this->input->post('name');
                    $data['email'] = $this->input->post('email');
                    $data['address1'] = $this->input->post('address1');
//                    $data['address2'] = $this->input->post('address2');
                    $data['company'] = $this->input->post('company');
                    $data['display_name'] = $this->input->post('display_name');
                    $data['create_timestamp'] = time();
                    $data['approve_timestamp'] = 0;
                    $data['approve_timestamp'] = 0;
                    $data['membership'] = 0;
                    $data['status'] = 'pending';

                    if ($this->input->post('password1') == $this->input->post('password2')) {
                        $password = $this->input->post('password1');
                        $data['password'] = sha1($password);
                        $this->db->insert('vendor', $data);
                        $this->email_model->account_opening('vendor', $data['email'], $password);
                        echo 'done';
                    }
                } else {
                    echo 'Disallowed charecter : " ' . $char . ' " in the POST';
                }
            }
        } else if ($para1 == 'registration') {
            $this->load->view('front/vendor_logup');
        }

    }

    /* FUNCTION: Concerning Login */
    function login($para1 = "", $para2 = "")
    {
        $page_data['page_name'] = "login";
        $this->load->library('form_validation');
        if ($para1 == "do_login") {
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == FALSE) {
                echo validation_errors();
            } else {
                $signin_data = $this->db->get_where('user', array(
                    'email' => $this->input->post('email'),
                    'password' => sha1($this->input->post('password'))
                ));
                if ($signin_data->num_rows() > 0) {
                    foreach ($signin_data->result_array() as $row) {
                        if($row['status']==0){
                            echo 'failed';
                        }else{
                        $this->session->set_userdata('user_login', 'yes');
                        $this->session->set_userdata('user_id', $row['user_id']);
                        $this->session->set_userdata('user_name', $row['username']);
                        $this->session->set_flashdata('alert', 'successful_signin');
                        $this->db->where('user_id', $row['user_id']);
                        $this->db->update('user', array(
                            'last_login' => time()
                        ));
                        echo 'done';
                        }
                    }
                } else {
                    echo 'failed';
                }
            }
        } else if ($para1 == 'forget') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'required');

            if ($this->form_validation->run() == FALSE) {
                echo validation_errors();
            } else {
                $query = $this->db->get_where('user', array(
                    'email' => $this->input->post('email')
                ));
                if ($query->num_rows() > 0) {
                    $user_id = $query->row()->user_id;
                    $password = substr(hash('sha512', rand()), 0, 12);
                    $data['password'] = sha1($password);
                    $this->db->where('user_id', $user_id);
                    $this->db->update('user', $data);
                    if ($this->email_model->password_reset_email('user', $user_id, $password)) {
                        echo 'email_sent';
                    } else {
                        echo 'email_not_sent';
                    }
                } else {
                    echo 'email_nay';
                }
            }
        }
    }

    /* FUNCTION: Setting login page with facebook and google */
    function login_set($para1 = '', $para2 = '')
    {
        $fb_login_set = $this->crud_model->get_type_name_by_id('general_settings', '51', 'value');
        $g_login_set = $this->crud_model->get_type_name_by_id('general_settings', '52', 'value');
        $page_data = array();
        $appid = $this->db->get_where('general_settings', array(
            'type' => 'fb_appid'
        ))->row()->value;
        $secret = $this->db->get_where('general_settings', array(
            'type' => 'fb_secret'
        ))->row()->value;
        $config = array(
            'appId' => $appid,
            'secret' => $secret
        );
        $this->load->library('Facebook', $config);

        if ($fb_login_set == 'ok') {
            // Try to get the user's id on Facebook
            $userId = $this->facebook->getUser();

            // If user is not yet authenticated, the id will be zero
            if ($userId == 0) {
                // Generate a login url
                //$page_data['url'] = $this->facebook->getLoginUrl(array('scope'=>'email')); 
                $page_data['url'] = $this->facebook->getLoginUrl(array(
                    'redirect_uri' => site_url('home/login_set/back/' . $para2),
                    'scope' => array(
                        "email"
                    ) // permissions here
                ));
                //redirect($data['url']);
            } else {
                // Get user's data and print it
                $page_data['user'] = $this->facebook->api('/me?fields=id,name,email,first_name,last_name,link');
                $page_data['url'] = site_url('home/login_set/back/' . $para2); // Logs off application
                //print_r($user);
            }
            if ($para1 == 'back') {
                $user = $this->facebook->api('/me?fields=id,name,email,first_name,last_name,link');
//                var_dump($user);
//                exit();
                if ($user_id = $this->crud_model->exists_in_table('user', 'fb_id', $user['id'])) {

                } else {
                    $data['username'] = $user['name'];
                    $data['email'] = $user['email'];
                    $data['surname'] = $user['last_name'];
                    $data['facebook'] = $user['link'];
                    $data['fb_id'] = $user['id'];
                    $data['wishlist'] = '[]';
                    $data['creation_date'] = time();
                    $data['password'] = substr(hash('sha512', rand()), 0, 12);

                    $this->db->insert('user', $data);
                    $user_id = $this->db->insert_id();
                }
                $this->session->set_userdata('user_login', 'yes');
                $this->session->set_userdata('user_id', $user_id);
                $this->session->set_userdata('user_name', $this->db->get_where('user', array(
                    'user_id' => $user_id
                ))->row()->username);
                $this->session->set_flashdata('alert', 'successful_signin');

                $this->db->where('user_id', $user_id);
                $this->db->update('user', array(
                    'last_login' => time()
                ));

                if ($para2 == 'cart') {
                    redirect(base_url() . 'index.php/home/cart_checkout', 'refresh');
                } else {
                    redirect(base_url() . 'index.php/home', 'refresh');
                }
            }
        }


        if ($g_login_set == 'ok') {
            $this->load->library('googleplus');
            if (isset($_GET['code'])) { //just_logged in

                $this->googleplus->client->authenticate($_GET['code']);
                $_SESSION['token'] = $this->googleplus->client->getAccessToken();
                $g_user = $this->googleplus->people->get('me');


                if ($user_id = $this->crud_model->exists_in_table('user', 'g_id', $g_user['id'])) {

                } else {
                    $data['username'] = $g_user['name']['givenName'];
                    $data['surname'] = $g_user['name']['familyName'];
                    $data['email'] = $g_user['emails'][0]['value'];
                    $data['wishlist'] = '[]';
                    $data['g_id'] = $g_user['id'];
                    $data['g_photo'] = $g_user['image']['url'];
                    $data['creation_date'] = time();
                    $data['password'] = substr(hash('sha512', rand()), 0, 12);
                    $this->db->insert('user', $data);
                    $user_id = $this->db->insert_id();
                }
                $this->session->set_userdata('user_login', 'yes');
                $this->session->set_userdata('user_id', $user_id);
                $this->session->set_userdata('user_name', $this->db->get_where('user', array(
                    'user_id' => $user_id
                ))->row()->username);
                $this->session->set_flashdata('alert', 'successful_signin');

                $this->db->where('user_id', $user_id);
                $this->db->update('user', array(
                    'last_login' => time()
                ));


                if ($para2 == 'cart') {
                    redirect(base_url() . 'index.php/home/cart_checkout', 'refresh');
                } else {
                    redirect(base_url() . 'index.php/home', 'refresh');
                }

            }
            if (isset($_SESSION['token']) && @$_SESSION['token']) {
                $this->googleplus->client->setAccessToken($_SESSION['token']);
            }

            if ($this->googleplus->client->getAccessToken()) //already_logged_in
            {
                $page_data['g_user'] = $this->googleplus->people->get('me');
                $page_data['g_url'] = $this->googleplus->client->createAuthUrl();
                $_SESSION['token'] = $this->googleplus->client->getAccessToken();
            } else {
                $page_data['g_url'] = $this->googleplus->client->createAuthUrl();
            }
        }

        if ($para1 == 'login') {
            $this->load->view('front/login', $page_data);
        } elseif ($para1 == 'registration') {
            $this->load->view('front/logup', $page_data);
        }
    }

    /* FUNCTION: Logout set */
    function logout()
    {
        $appid = $this->db->get_where('general_settings', array(
            'type' => 'fb_appid'
        ))->row()->value;
        $secret = $this->db->get_where('general_settings', array(
            'type' => 'fb_secret'
        ))->row()->value;
        $config = array(
            'appId' => $appid,
            'secret' => $secret
        );
        $this->load->library('Facebook', $config);

        $this->facebook->destroySession();
        $this->session->sess_destroy();
        redirect(base_url() . 'index.php/home/logged_out', 'refresh');
    }

    /* FUNCTION: Logout */
    function logged_out()
    {
        $this->session->set_flashdata('alert', 'successful_signout');
        redirect(base_url() . 'index.php/home/', 'refresh');
    }

    /* FUNCTION: Check if Email user exists */
    function exists()
    {
        $email = $this->input->post('email');
        $user = $this->db->get('user')->result_array();
        $exists = 'no';
        foreach ($user as $row) {
            if ($row['email'] == $email) {
                $exists = 'yes';
            }
        }
        echo $exists;
    }

    /* FUNCTION: Newsletter Subscription */
    function subscribe()
    {
        $safe = 'yes';
        $char = '';
        foreach ($_POST as $row) {
            if (preg_match('/[\'^":()}{#~><>|=+¬]/', $row, $match)) {
                $safe = 'no';
                $char = $match[0];
            }
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
        } else {
            if ($safe == 'yes') {
                $subscribe_num = $this->session->userdata('subscriber');
                $email = $this->input->post('email');
                $subscriber = $this->db->get('subscribe')->result_array();
                $exists = 'no';
                foreach ($subscriber as $row) {
                    if ($row['email'] == $email) {
                        $exists = 'yes';
                    }
                }
                if ($exists == 'yes') {
                    echo 'already';
                } else if ($subscribe_num >= 3) {
                    echo 'already_session';
                } else if ($exists == 'no') {
                    $subscribe_num = $subscribe_num + 1;
                    $this->session->set_userdata('subscriber', $subscribe_num);
                    $data['email'] = $email;
                    $this->db->insert('subscribe', $data);
                    echo 'done';
                }
            } else {
                echo 'Disallowed charecter : " ' . $char . ' " in the POST';
            }
        }
    }



    /* FUNCTION: Customer Registration*/
    function registration($para1 = "", $para2 = "" ,$para3 = "")
    {
        $safe = 'yes';
        $char = '';
        foreach ($_POST as $k => $row) {
            if (preg_match('/[\'^":()}{#~><>|=+¬]/', $row, $match)) {
                if ($k !== 'password1' && $k !== 'password2') {
                    $safe = 'no';
                    $char = $match[0];
                }
            }
        }

        $this->load->library('form_validation');
        $page_data['page_name'] = "registration";
        if ($para1 == "add_info") {
            $this->form_validation->set_rules('username', 'Your First Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|is_unique[user.email]', array('required' => 'You have not provided %s.', 'is_unique' => 'This %s already exists.'));
            $this->form_validation->set_rules('password1', 'Password', 'required');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'required');
            $this->form_validation->set_rules('birthday', 'Birthday', 'required');
            $this->form_validation->set_rules('checkbox_gender', 'Gender', 'required');
//            $this->form_validation->set_rules('address1', 'Address Line 1', 'required');
//            $this->form_validation->set_rules('address2', 'Address Line 2', 'required');
//            $this->form_validation->set_rules('phone', 'Phone', 'required');
            $this->form_validation->set_rules('surname', 'Your Last Name', 'required');
//            $this->form_validation->set_rules('zip', 'ZIP', 'required');
//            $this->form_validation->set_rules('city', 'City', 'required');


            if ($this->form_validation->run() == FALSE) {
                echo validation_errors();
            } else {
                if ($safe == 'yes') {
                    $active_key = session_id();
                    $data['username'] = $this->input->post('username');
                    $data['email'] = $this->input->post('email');
                    $data['birthday'] = $this->input->post('birthday');
                    $data['gender'] = $this->input->post('checkbox_gender');
    				$data['address1']      = $this->input->post('address1');
//    				$data['address2']      = $this->input->post('address2');
//    				$data['phone']         = $this->input->post('phone');
                    $data['surname'] = $this->input->post('surname');
                    $data['activekey'] = $active_key;
                    $data['status'] = 0;
//    				$data['zip']           = $this->input->post('zip');
//    				$data['city']          = $this->input->post('city');
                    $data['langlat'] = '';
                    $data['wishlist'] = '[]';
                    $data['creation_date'] = time();
                    $setdata = array(
                        'pre_username'  => $data['username'],
                        'pre_email'     => $data['email'],
                    );
                    $this->session->set_userdata($setdata);

                    if ($this->input->post('password1') == $this->input->post('password2')) {
                        $password = $this->input->post('password1');
                        $data['password'] = sha1($password);
                        $this->db->insert('user', $data);
                        $this->email_model->account_confirm('user', $data['email'], $password, $active_key);
                        echo "done";
                    }
                } else {
                    echo 'Disallowed charecter : " ' . $char . ' " in the POST';
                }
            }
        } else if ($para1 == "update_info") {
            $id = $this->session->userdata('user_id');
            $data['username'] = $this->input->post('username');
            $data['surname'] = $this->input->post('surname');
            $data['birthday'] = $this->input->post('birthday');
            $data['gender'] = $this->input->post('checkbox_gender');
            $data['address1'] = $this->input->post('address1');
            $data['address2'] = $this->input->post('address2');
            $data['phone'] = $this->input->post('phone');
            $data['city'] = $this->input->post('city');
            $data['skype'] = $this->input->post('skype');
            $data['google_plus'] = $this->input->post('google_plus');
            $data['facebook'] = $this->input->post('facebook');
            $data['zip'] = $this->input->post('zip');

            $this->crud_model->file_up('image', 'user', $id);

            $this->db->where('user_id', $id);
            $this->db->update('user', $data);
            redirect(base_url() . 'index.php/home/profile/', 'refresh');
        } else if ($para1 == "update_password") {
            $user_data['password'] = $this->input->post('password');
            $account_data = $this->db->get_where('user', array(
                'user_id' => $this->session->userdata('user_id')
            ))->result_array();
            foreach ($account_data as $row) {
                if (sha1($user_data['password']) == $row['password']) {
                    if ($this->input->post('password1') == $this->input->post('password2')) {
                        $data['password'] = sha1($this->input->post('password1'));
                        $this->db->where('user_id', $this->session->userdata('user_id'));
                        $this->db->update('user', $data);
                        redirect(base_url() . 'index.php/home/profile/', 'refresh');
                    }
                } else {
                    echo 'pass_prb';
                }
            }
            redirect(base_url() . 'index.php/home/', 'refresh');
        } else if ($para1 == "account_confirm") {
            $data['status'] = 1;
            $this->db->where('activekey', $para2);
            $this->db->update('user', $data);
            redirect(base_url() . 'index.php/home/user/confirm_success', 'refresh');
        }else {
            $this->load->view('front/registration', $page_data);
        }
    }

    function user($para1 = "", $para2 = "" ,$para3 = "")
    {
        if ($para1=='confirm'){
            $page_data['page_name'] = "user_confirm";
            $page_data['page_title'] = translate('Please Confirm Email');
            $page_data['message'] = "Please Confirm Email";
            $this->load->view('front/index', $page_data);
        }elseif ($para1=='confirm_success'){
            $page_data['page_name'] = "confirm_success";
            $page_data['page_title'] = translate('Confirm Success');
            $page_data['message'] = "Confirm Success";
            $this->load->view('front/index', $page_data);
        }
    }

    function error()
    {
        $this->load->view('front/error');
    }


    /* FUNCTION: Product rating*/
    function rating($product_id, $rating)
    {
        if ($this->session->userdata('user_login') != "yes") {
            redirect(base_url() . 'index.php/home/login/', 'refresh');
        }
        if ($rating <= 5) {
            if ($this->crud_model->set_rating($product_id, $rating) == 'yes') {
                echo 'success';
            } else if ($this->crud_model->set_rating($product_id, $rating) == 'no') {
                echo 'already';
            }
        } else {
            echo 'failure';
        }
    }


    /* FUNCTION: Concering Add, Remove and Updating Cart Items*/
    function cart($para1 = '', $para2 = '', $para3 = '', $para4 = '')
    {

        if ($para1 == "add") {
            $qty = $this->input->post('qty');
            $color = $this->input->post('color');
            $option = array('color' => array('title' => 'Color', 'value' => $color));
            $all_op = json_decode($this->crud_model->get_type_name_by_id('product', $para2, 'options'), true);

            if ($all_op) {
                foreach ($all_op as $ro) {
                    $name = $ro['name'];
                    $title = $ro['title'];
                    $option[$name] = array('title' => $title, 'value' => $this->input->post($name));
                }
            }
//            var_dump($option);
            if ($para3 == 'pp') {
                $carted = $this->cart->contents();
                foreach ($carted as $items) {
                    if ($items['id'] == $para2) {
                        $data = array(
                            'rowid' => $items['rowid'],
                            'qty' => 0
                        );
                    } else {
                        $data = array(
                            'rowid' => $items['rowid'],
                            'qty' => $items['qty']
                        );
                    }
                    $this->cart->update($data);
                }
            }

            $data = array(
                'id' => $para2,
                'qty' => $qty,
                'option' => json_encode($option),
                'price' => $this->crud_model->get_product_price($para2),
                'name' => $this->crud_model->get_type_name_by_id('product', $para2, 'title'),
                'shipping' => $this->crud_model->get_shipping_cost($para2),
                'tax' => $this->crud_model->get_product_tax($para2),
                'image' => $this->crud_model->file_view('product', $para2, '', '', 'thumb', 'src', 'multi', 'one'),
                'coupon' => ''
            );


            $stock = $this->crud_model->get_type_name_by_id('product', $para2, 'current_stock');
            // var_dump($this->crud_model->is_added_to_cart($para2));exit();
            if (!$this->crud_model->is_added_to_cart($para2) || $para3 == 'pp') {
                if ($stock >= $qty) {
                    $this->cart->insert($data);
                    echo 'added';
                } else {
                    // เช็คสต๊อก //
                    echo 'shortage';

                    // ไม่เช็คสต็อก //
                    // $this->cart->insert($data);
                    // echo 'added';
                }
            } else {
                echo 'already';
            }
//            var_dump($this->cart->contents());
        }

        if ($para1 == "added_list") {
            $page_data['carted'] = $this->cart->contents();
            $this->load->view('front/added_list', $page_data);
        }

        if ($para1 == "empty") {
            $this->cart->destroy();
            $this->session->set_userdata('couponer', '');
        }

        if ($para1 == "quantity_update") {

            $carted = $this->cart->contents();
            foreach ($carted as $items) {
                if ($items['rowid'] == $para2) {
                    $product = $items['id'];
                }
            }
            $current_quantity = $this->crud_model->get_type_name_by_id('product', $product, 'current_stock');
            $msg = 'not_limit';

            foreach ($carted as $items) {
                if ($items['rowid'] == $para2) {
                    if ($current_quantity >= $para3) {
                        $data = array(
                            'rowid' => $items['rowid'],
                            'qty' => $para3
                        );
                    } else {
                        $msg = $current_quantity;
                        $data = array(
                            'rowid' => $items['rowid'],
                            'qty' => $current_quantity
                        );
                    }
                } else {
                    $data = array(
                        'rowid' => $items['rowid'],
                        'qty' => $items['qty']
                    );
                }
                $this->cart->update($data);
            }
            $return = '';
            $carted = $this->cart->contents();
            foreach ($carted as $items) {
                if ($items['rowid'] == $para2) {
                    $return = currency() . $items['subtotal'];
                }
            }
            $return .= '---' . $msg;
            echo $return;
        }

        if ($para1 == "remove_one") {
            $carted = $this->cart->contents();
            foreach ($carted as $items) {
                if ($items['rowid'] == $para2) {
                    $data = array(
                        'rowid' => $items['rowid'],
                        'qty' => 0
                    );
                } else {
                    $data = array(
                        'rowid' => $items['rowid'],
                        'qty' => $items['qty']
                    );
                }
                $this->cart->update($data);
            }
        }

        if ($para1 == 'calcs') {
            $total = $this->cart->total();
            if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') {
                $shipping = $this->crud_model->cart_total_it('shipping');
            } elseif ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'fixed') {
                $shipping = $this->crud_model->get_type_name_by_id('business_settings', '2', 'value');
            }

                $shipping_condition = $this->crud_model->get_type_name_by_id('business_settings', '16', 'value');


            $tax = $this->crud_model->cart_total_it('tax');

            if ($shipping_condition < $total){
                $shipping = 0;
            }


            $grand = $total + $shipping + $tax;
            if ($para2 == 'full') {
                $total = $this->cart->format_number($total);
                $ship = $this->cart->format_number($shipping);
                $tax = $this->cart->format_number($tax);
                $grand = $this->cart->format_number($grand);
                $count = count($this->cart->contents());

                if ($total == '') {
                    $total = 0;
                }
                if ($ship == '') {
                    $ship = 0;
                }
                if ($tax == '') {
                    $tax = 0;
                }
                if ($grand == '') {
                    $grand = 0;
                }


                $total = currency() . $total;
                $ship = currency() . $shipping;
                $tax = currency() . $tax;
                $grand = currency() . $grand;

                echo $total . '-' . $ship . '-' . $tax . '-' . $grand . '-' . $count;
            }

            if ($para2 == 'prices') {
                $carted = $this->cart->contents();
                $return = array();
                foreach ($carted as $row) {
                    $return[] = array('id' => $row['rowid'], 'price' => currency() . $this->cart->format_number($row['price']), 'subtotal' => currency() . $this->cart->format_number($row['subtotal']));
                }
                echo json_encode($return);
            }
        }

    }

    /* FUNCTION: Loads Cart Checkout Page*/
    function cart_checkout($para1 = "")
    {
        $carted = $this->cart->contents();
        if (count($carted) <= 0) {
            redirect(base_url() . 'index.php/home/', 'refresh');
        }
        $page_data['logger'] = $para1;
        $page_data['page_name'] = "cart";
        $page_data['page_title'] = translate('my_cart');
        $page_data['carted'] = $this->cart->contents();
        $page_data['another_address'] = $this->db->get_where('another_address', array('user_id' => $this->session->userdata('user_id')))->result_array();
        $page_data['provinces'] = $this->db->get_where('provinces')->result_array();
        $page_data['payment_method'] = $this->db->get_where('payment_method')->result_array();

        $this->load->view('front/index', $page_data);
    }


    /* FUNCTION: Loads Cart Checkout Page*/
    function coupon_check()
    {
        $para1 = $this->input->post('code');
//        var_dump($para1);
//        exit();
        $carted = $this->cart->contents();
        if (count($carted) > 0) {
            $p = $this->session->userdata('coupon_apply') + 1;
            $this->session->set_userdata('coupon_apply', $p);
            $p = $this->session->userdata('coupon_apply');
            if ($p < 10) {
                $c = $this->db->get_where('coupon', array('code' => $para1));
                $coupon = $c->result_array();
                //echo $c->num_rows();
                //,'till <= '=>date('Y-m-d')
                if ($c->num_rows() > 0) {
                    foreach ($coupon as $row) {
                        $spec = json_decode($row['spec'], true);
                        $coupon_id = $row['coupon_id'];
                        $till = strtotime($row['till']);
                    }
                    if ($till > time()) {
                        $ro = $spec;
                        $type = $ro['discount_type'];
                        $value = $ro['discount_value'];
                        $set_type = $ro['set_type'];
                        $set = json_decode($ro['set']);
                        if ($set_type !== 'total_amount') {
                            $dis_pro = array();
                            $set_ra = array();
                            if ($set_type == 'all_products') {
                                $set_ra[] = $this->db->get('product')->result_array();
                            } else {
                                foreach ($set as $p) {
                                    if ($set_type == 'product') {
                                        $set_ra[] = $this->db->get_where('product', array('product_id' => $p))->result_array();
                                    } else {
                                        $set_ra[] = $this->db->get_where('product', array($set_type => $p))->result_array();
                                    }
                                }
                            }
                            foreach ($set_ra as $set) {
                                foreach ($set as $n) {
                                    $dis_pro[] = $n['product_id'];
                                }
                            }
                            foreach ($carted as $items) {
                                if (in_array($items['id'], $dis_pro)) {
                                    $base_price = $this->crud_model->get_product_price($items['id']);
                                    if ($type == 'percent') {
                                        $discount = $base_price * $value / 100;
                                    } else if ($type == 'amount') {
                                        $discount = $value;
                                    }
                                    $data = array(
                                        'rowid' => $items['rowid'],
                                        'price' => $base_price - $discount,
                                        'coupon' => $coupon_id
                                    );

                                } else {
                                    $data = array(
                                        'rowid' => $items['rowid'],
                                        'price' => $items['price'],
                                        'coupon' => $items['coupon']
                                    );
                                }
                                $this->cart->set_discount($discount);
                                $this->cart->update($data);
                            }
//                            echo 'wise:-:-:' . translate('coupon_discount_activated');
                            echo 'total:-:-:' . translate('coupon_discount_activated') . ':-:-:' . currency() . $value;
                        } else {
                            $this->cart->set_discount($value);
                            echo 'total:-:-:' . translate('coupon_discount_activated') . ':-:-:' . currency() . $value;
                        }
                        $this->cart->set_coupon($coupon_id);
                        $this->session->set_userdata('couponer', 'done');
                        $this->session->set_userdata('coupon_apply', 0);
                    } else {
                        echo 'nope';
                    }
                } else {
                    echo 'nope';
                }
            } else {
                echo 'Too many coupon request!';
            }
        }
    }


    /* FUNCTION: Finalising Purchase*/
    function cart_finish($para1 = "", $para2 = "")
    {
        if ($this->session->userdata('user_login') == 'yes') {
            $carted = $this->cart->contents();
            $total = $this->cart->total();
            $exchange = $this->crud_model->get_type_name_by_id('business_settings', '8', 'value');
            $vat_per = '';
            $vat = $this->crud_model->cart_total_it('tax');
            if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') {
                $shipping = $this->crud_model->cart_total_it('shipping');
            } else {
                $shipping = $this->crud_model->get_type_name_by_id('business_settings', '2', 'value');
            }
            $grand_total = $total + $vat + $shipping;
            $product_details = json_encode($carted);

            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->update('user', array(
                'langlat' => $this->input->post('langlat')
            ));

            if ($this->input->post('payment_type') == 'paypal') {
                if ($para1 == 'go') {

                    $data['buyer'] = $this->session->userdata('user_id');
                    $data['product_details'] = $product_details;
                    $data['shipping_address'] = json_encode($_POST);
                    $data['vat'] = $vat;
                    $data['vat_percent'] = $vat_per;
                    $data['shipping'] = $shipping;
                    $data['delivery_status'] = '[]';
                    $data['payment_type'] = $para1;
                    $data['payment_status'] = '[]';
                    $data['payment_details'] = 'none';
                    $data['grand_total'] = $grand_total;
                    $data['sale_datetime'] = time();
                    $data['delivary_datetime'] = '';
                    $paypal_email = $this->crud_model->get_type_name_by_id('business_settings', '1', 'value');

                    $this->db->insert('sale', $data);
                    $sale_id = $this->db->insert_id();
                    $vendors = $this->crud_model->vendors_in_sale($sale_id);
                    $delivery_status = array();
                    $payment_status = array();
                    foreach ($vendors as $p) {
                        $delivery_status[] = array('vendor' => $p, 'status' => 'pending', 'delivery_time' => '');
                        $payment_status[] = array('vendor' => $p, 'status' => 'due');
                    }
                    if ($this->crud_model->is_admin_in_sale($sale_id)) {
                        $delivery_status[] = array('admin' => '', 'status' => 'pending', 'delivery_time' => '');
                        $payment_status[] = array('admin' => '', 'status' => 'due');
                    }
                    $data['sale_code'] = date('Ym', $data['sale_datetime']) . $sale_id;
                    $data['delivery_status'] = json_encode($delivery_status);
                    $data['payment_status'] = json_encode($payment_status);
                    $this->db->where('sale_id', $sale_id);
                    $this->db->update('sale', $data);

                    $this->session->set_userdata('sale_id', $sale_id);

                    /****TRANSFERRING USER TO PAYPAL TERMINAL****/
                    $this->paypal->add_field('rm', 2);
                    $this->paypal->add_field('no_note', 0);
                    $this->paypal->add_field('cmd', '_cart');
                    $this->paypal->add_field('upload', '1');
                    $i = 1;

                    foreach ($carted as $val) {
                        $this->paypal->add_field('item_number_' . $i, $i);
                        $this->paypal->add_field('item_name_' . $i, $val['name']);
                        $this->paypal->add_field('amount_' . $i, $this->cart->format_number(($val['price'] / $exchange)));
                        if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') {
                            $this->paypal->add_field('shipping_' . $i, $this->cart->format_number((($val['shipping'] / $exchange) * $val['qty'])));
                        }
                        $this->paypal->add_field('tax_' . $i, $this->cart->format_number(($val['tax'] / $exchange)));
                        $this->paypal->add_field('quantity_' . $i, $val['qty']);
                        $i++;
                    }
                    if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'fixed') {
                        $this->paypal->add_field('shipping_1', $this->cart->format_number(($this->crud_model->get_type_name_by_id('business_settings', '2', 'value') / $exchange)));
                    }
                    //$this->paypal->add_field('amount', $grand_total);
                    $this->paypal->add_field('custom', $sale_id);
                    $this->paypal->add_field('business', $paypal_email);
                    $this->paypal->add_field('notify_url', base_url() . 'index.php/home/paypal_ipn');
                    $this->paypal->add_field('cancel_return', base_url() . 'index.php/home/paypal_cancel');
                    $this->paypal->add_field('return', base_url() . 'index.php/home/paypal_success');

                    $this->paypal->submit_paypal_post();
                    // submit the fields to paypal
                }

            } else if ($this->input->post('payment_type') == 'cash_on_delivery') {
                if ($para1 == 'go') {

                    if ($_POST['check_other']==""){
                        $data_user['address1'] = $_POST['address1'];
//                        $data_user['address2'] = $_POST['address2'];
                        $data_user['phone'] = $_POST['phone'];
                        $data_user['city'] = $_POST['city'];
                        $data_user['zip'] = $_POST['zip'];
                        $data_user['line'] = $_POST['line'];
                        $this->db->where('user_id', $this->session->userdata('user_id'));
                        $this->db->update('user', $data_user);

                        $data_other['firstname'] = $_POST['firstname'];
                        $data_other['lastname'] = $_POST['lastname'];
                        $data_other['address'] = $_POST['address1'];
                        $data_other['city'] = $_POST['city'];
                        $data_other['postal_code'] = $_POST['zip'];
                        $data_other['province'] = $_POST['province'];
                        $data_other['tel'] = $_POST['phone'];
                        $data_other['line'] = $_POST['line'];
                        $data_other['user_id'] = $this->session->userdata('user_id');
                        $this->db->insert('another_address', $data_other);
                        $data['shipping_address'] = json_encode($_POST);
                    }elseif  ($_POST['check_other']=="add_ano"){
                        $data_other['firstname'] = $_POST['firstname_ot'];
                        $data_other['lastname'] = $_POST['lastname_ot'];
                        $data_other['address'] = $_POST['address_ot'];
                        $data_other['city'] = $_POST['city_ot'];
                        $data_other['postal_code'] = $_POST['postal_code_ot'];
                        $data_other['province'] = $_POST['province_ot'];
                        $data_other['tel'] = $_POST['phone_ot'];
                        $data_other['line'] = $_POST['line'];
                        $data_other['user_id'] = $this->session->userdata('user_id');
                        $this->db->insert('another_address', $data_other);
                        $other_id = $this->db->insert_id();
                        $address = $this->db->get_where('another_address', array('id' => $other_id))->row();
                        $data['shipping_address'] = json_encode($address);
                    }else{

                        $address = $this->db->get_where('another_address', array('id' => $_POST['check_other']))->row();
                        $data['shipping_address'] = json_encode($address);
                    }


                    if (isset($_POST['check_tax'])){
                        $data_tax['first_name_tax'] = $_POST['first_name_tax'];
                        $data_tax['last_name_tax'] = $_POST['last_name_tax'];
                        $data_tax['address_tax'] = $_POST['address_tax'];
                        $data_tax['postal_code_tax'] = $_POST['postal_code_tax'];
                        $data_tax['city_tax'] = $_POST['city_tax'];
                        $data_tax['province_tax'] = $_POST['province_tax'];
                        $data_tax['tel_tax'] = $_POST['tel_tax'];
                        $data_tax['tax_code'] = $_POST['tax_code'];
                        $data_tax['tin'] = $_POST['tin'];
                        $data_tax['user_id'] = $this->session->userdata('user_id');
                        $this->db->insert('tax_address', $data_tax);
                    }


                    $data['buyer'] = $this->session->userdata('user_id');
                    $data['product_details'] = $product_details;
                    $data['vat'] = $vat;
                    $data['vat_percent'] = $vat_per;
                    $data['shipping'] = $shipping;
                    $data['delivery_status'] = '[]';
                    $data['payment_type'] = 'cash_on_delivery';
                    $data['payment_chk'] = $_POST['payment_type_chk'];
                    $data['payment_status'] = '[]';
                    $data['payment_details'] = '';
                    $data['grand_total'] = $grand_total;
                    $data['sale_datetime'] = time();
                    $data['delivary_datetime'] = '';
                    $data['coupon_discount'] = $_POST['discount_cu'];

                    $this->db->insert('sale', $data);
                    $sale_id = $this->db->insert_id();
                    $vendors = $this->crud_model->vendors_in_sale($sale_id);
                    $delivery_status = array();
                    $payment_status = array();
                    foreach ($vendors as $p) {
                        $delivery_status[] = array('vendor' => $p, 'status' => 'pending', 'delivery_time' => '');
                        $payment_status[] = array('vendor' => $p, 'status' => 'due');
                    }
                    if ($this->crud_model->is_admin_in_sale($sale_id)) {
                        $delivery_status[] = array('admin' => '', 'status' => 'pending', 'delivery_time' => '');
                        $payment_status[] = array('admin' => '', 'status' => 'due');
                    }
                    $data['sale_code'] = date('Ym', $data['sale_datetime']) . $sale_id;
                    $data['delivery_status'] = json_encode($delivery_status);
                    $data['payment_status'] = json_encode($payment_status);
                    $this->db->where('sale_id', $sale_id);
                    $this->db->update('sale', $data);

                    foreach ($carted as $value) {
                        $this->crud_model->decrease_quantity($value['id'], $value['qty']);
                        $data1['type'] = 'destroy';
                        $data1['category'] = $this->db->get_where('product', array(
                            'product_id' => $value['id']
                        ))->row()->category;
                        $data1['sub_category'] = $this->db->get_where('product', array(
                            'product_id' => $value['id']
                        ))->row()->sub_category;
                        $data1['product'] = $value['id'];
                        $data1['quantity'] = $value['qty'];
                        $data1['total'] = 0;
                        $data1['reason_note'] = 'sale';
                        $data1['sale_id'] = $sale_id;
                        $data1['datetime'] = time();
                        $this->db->insert('stock', $data1);
                    }
                    $this->crud_model->email_invoice($sale_id);
                    $this->cart->destroy();
                    $this->session->set_userdata('couponer', '');
                    //echo $sale_id;
                    redirect(base_url() . 'index.php/home/invoice/' . $sale_id, 'refresh');
                }
            } else if ($this->input->post('payment_type') == 'stripe') {
                if ($para1 == 'go') {
                    if (isset($_POST['stripeToken'])) {

                        require_once(APPPATH . 'libraries/stripe-php/init.php');
                        $stripe_api_key = $this->db->get_where('business_settings', array('type' => 'stripe_secret'))->row()->value;
                        Stripe::setApiKey($stripe_api_key); //system payment settings
                        $customer_email = $this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->email;

                        $customer = Customer::create(array(
                            'email' => $customer_email, // customer email id
                            'card' => $_POST['stripeToken']
                        ));

                        $charge = Charge::create(array(
                            'customer' => $customer->id,
                            'amount' => ceil($grand_total * 100 / $exchange),
                            'currency' => 'USD'
                        ));

                        if ($charge->paid == true) {
                            $customer = (array)$customer;
                            $charge = (array)$charge;

                            $data['buyer'] = $this->session->userdata('user_id');
                            $data['product_details'] = $product_details;
                            $data['shipping_address'] = json_encode($_POST);
                            $data['vat'] = $vat;
                            $data['vat_percent'] = $vat_per;
                            $data['shipping'] = $shipping;
                            $data['delivery_status'] = 'pending';
                            $data['payment_type'] = 'stripe';
                            $data['payment_status'] = 'paid';
                            $data['payment_details'] = "Customer Info: \n" . json_encode($customer, true) . "\n \n Charge Info: \n" . json_encode($charge, true);
                            $data['grand_total'] = $grand_total;
                            $data['sale_datetime'] = time();
                            $data['delivary_datetime'] = '';

                            $this->db->insert('sale', $data);
                            $sale_id = $this->db->insert_id();
                            $vendors = $this->crud_model->vendors_in_sale($sale_id);
                            $delivery_status = array();
                            $payment_status = array();
                            foreach ($vendors as $p) {
                                $delivery_status[] = array('vendor' => $p, 'status' => 'pending', 'delivery_time' => '');
                                $payment_status[] = array('vendor' => $p, 'status' => 'paid');
                            }
                            if ($this->crud_model->is_admin_in_sale($sale_id)) {
                                $delivery_status[] = array('admin' => '', 'status' => 'pending', 'delivery_time' => '');
                                $payment_status[] = array('admin' => '', 'status' => 'paid');
                            }
                            $data['sale_code'] = date('Ym', $data['sale_datetime']) . $sale_id;
                            $data['delivery_status'] = json_encode($delivery_status);
                            $data['payment_status'] = json_encode($payment_status);
                            $this->db->where('sale_id', $sale_id);
                            $this->db->update('sale', $data);

                            foreach ($carted as $value) {
                                $this->crud_model->decrease_quantity($value['id'], $value['qty']);
                                $data1['type'] = 'destroy';
                                $data1['category'] = $this->db->get_where('product', array(
                                    'product_id' => $value['id']
                                ))->row()->category;
                                $data1['sub_category'] = $this->db->get_where('product', array(
                                    'product_id' => $value['id']
                                ))->row()->sub_category;
                                $data1['product'] = $value['id'];
                                $data1['quantity'] = $value['qty'];
                                $data1['total'] = 0;
                                $data1['reason_note'] = 'sale';
                                $data1['sale_id'] = $sale_id;
                                $data1['datetime'] = time();
                                $this->db->insert('stock', $data1);
                            }
                            $this->crud_model->email_invoice($sale_id);
                            $this->cart->destroy();
                            $this->session->set_userdata('couponer', '');
                            redirect(base_url() . 'index.php/home/invoice/' . $sale_id, 'refresh');
                        } else {
                            $this->session->set_flashdata('alert', 'unsuccessful_stripe');
                            redirect(base_url() . 'index.php/home/cart_checkout/', 'refresh');
                        }

                    } else {
                        $this->session->set_flashdata('alert', 'unsuccessful_stripe');
                        redirect(base_url() . 'index.php/home/cart_checkout/', 'refresh');
                    }
                }
            }

        } else {
//            //echo 'nope';
//            redirect(base_url() . 'index.php/home/cart_checkout/need_login', 'refresh');
                $carted = $this->cart->contents();
                $total = $this->cart->total();
                $exchange = $this->crud_model->get_type_name_by_id('business_settings', '8', 'value');
                $vat_per = '';
                $vat = $this->crud_model->cart_total_it('tax');
                if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') {
                    $shipping = $this->crud_model->cart_total_it('shipping');
                } else {
                    $shipping = $this->crud_model->get_type_name_by_id('business_settings', '2', 'value');
                }
                $grand_total = $total + $vat + $shipping;
                $product_details = json_encode($carted);

                if ($this->input->post('payment_type') == 'cash_on_delivery') {
                    if ($para1 == 'go') {
                        $time_userid = time();
                        if ($_POST['check_other']==""){
                            $data_user['username'] = $_POST['firstname'];
                            $data_user['surname'] = $_POST['lastname'];
                            $data_user['address1'] = $_POST['address1'];
                            $data_user['email'] = $_POST['email'];
//                          $data_user['address2'] = $_POST['address2'];
                            $data_user['phone'] = $_POST['phone'];
                            $data_user['city'] = $_POST['city'];
                            $data_user['zip'] = $_POST['zip'];
                            $data_user['user_id'] = $time_userid;
                            $this->db->insert('user', $data_user);
//                            $this->db->where('user_id', $this->session->userdata('user_id'));
//                            $this->db->update('user', $data_user);

                            $data_other['firstname'] = $_POST['firstname'];
                            $data_other['lastname'] = $_POST['lastname'];
                            $data_other['address'] = $_POST['address1'];
                            $data_other['city'] = $_POST['city'];
                            $data_other['postal_code'] = $_POST['zip'];
                            $data_other['province'] = $_POST['province'];
                            $data_other['tel'] = $_POST['phone'];
                            $data_other['user_id'] = $time_userid;
                            $this->db->insert('another_address', $data_other);
                            $data['shipping_address'] = json_encode($_POST);
                        }elseif  ($_POST['check_other']=="add_ano"){
                            $data_other['firstname'] = $_POST['firstname_ot'];
                            $data_other['lastname'] = $_POST['lastname_ot'];
                            $data_other['address'] = $_POST['address_ot'];
                            $data_other['city'] = $_POST['city_ot'];
                            $data_other['postal_code'] = $_POST['postal_code_ot'];
                            $data_other['province'] = $_POST['province_ot'];
                            $data_other['tel'] = $_POST['phone_ot'];
                            $data_other['user_id'] = $time_userid;
                            $this->db->insert('another_address', $data_other);
                            $other_id = $this->db->insert_id();
                            $address = $this->db->get_where('another_address', array('id' => $other_id))->row();
                            $data['shipping_address'] = json_encode($address);
                        }else{

                            $address = $this->db->get_where('another_address', array('id' => $_POST['check_other']))->row();
                            $data['shipping_address'] = json_encode($address);
                        }


                        if (isset($_POST['check_tax'])){
                            $data_tax['first_name_tax'] = $_POST['first_name_tax'];
                            $data_tax['last_name_tax'] = $_POST['last_name_tax'];
                            $data_tax['address_tax'] = $_POST['address_tax'];
                            $data_tax['postal_code_tax'] = $_POST['postal_code_tax'];
                            $data_tax['city_tax'] = $_POST['city_tax'];
                            $data_tax['province_tax'] = $_POST['province_tax'];
                            $data_tax['tel_tax'] = $_POST['tel_tax'];
                            $data_tax['tax_code'] = $_POST['tax_code'];
                            $data_tax['tin'] = $_POST['tin'];
                            $data_tax['user_id'] = $time_userid;
                            $this->db->insert('tax_address', $data_tax);
                        }


                        $data['buyer'] = $time_userid;
                        $data['product_details'] = $product_details;
                        $data['vat'] = $vat;
                        $data['vat_percent'] = $vat_per;
                        $data['shipping'] = $shipping;
                        $data['delivery_status'] = '[]';
                        $data['payment_type'] = 'cash_on_delivery';
                        $data['payment_chk'] = $_POST['payment_type_chk'];
                        $data['payment_status'] = '[]';
                        $data['payment_details'] = '';
                        $data['grand_total'] = $grand_total;
                        $data['sale_datetime'] = time();
                        $data['delivary_datetime'] = '';
                        $data['coupon_discount'] = $_POST['discount_cu'];

                        $this->db->insert('sale', $data);
                        $sale_id = $this->db->insert_id();
                        $vendors = $this->crud_model->vendors_in_sale($sale_id);
                        $delivery_status = array();
                        $payment_status = array();
                        foreach ($vendors as $p) {
                            $delivery_status[] = array('vendor' => $p, 'status' => 'pending', 'delivery_time' => '');
                            $payment_status[] = array('vendor' => $p, 'status' => 'due');
                        }
                        if ($this->crud_model->is_admin_in_sale($sale_id)) {
                            $delivery_status[] = array('admin' => '', 'status' => 'pending', 'delivery_time' => '');
                            $payment_status[] = array('admin' => '', 'status' => 'due');
                        }
                        $data['sale_code'] = date('Ym', $data['sale_datetime']) . $sale_id;
                        $data['delivery_status'] = json_encode($delivery_status);
                        $data['payment_status'] = json_encode($payment_status);
                        $this->db->where('sale_id', $sale_id);
                        $this->db->update('sale', $data);

                        foreach ($carted as $value) {
                            $this->crud_model->decrease_quantity($value['id'], $value['qty']);
                            $data1['type'] = 'destroy';
                            $data1['category'] = $this->db->get_where('product', array(
                                'product_id' => $value['id']
                            ))->row()->category;
                            $data1['sub_category'] = $this->db->get_where('product', array(
                                'product_id' => $value['id']
                            ))->row()->sub_category;
                            $data1['product'] = $value['id'];
                            $data1['quantity'] = $value['qty'];
                            $data1['total'] = 0;
                            $data1['reason_note'] = 'sale';
                            $data1['sale_id'] = $sale_id;
                            $data1['datetime'] = time();
                            $this->db->insert('stock', $data1);
                        }
                        $this->crud_model->email_invoice($sale_id);
                        $this->cart->destroy();
                        $this->session->set_userdata('couponer', '');
                        //echo $sale_id;
                        redirect(base_url() . 'index.php/home/invoice/' . $sale_id, 'refresh');
                    }
                }

        }

    }


    /* FUNCTION: Verify paypal payment by IPN*/
    function paypal_ipn()
    {
        if ($this->paypal->validate_ipn() == true) {

            $data['payment_details'] = json_encode($_POST);
            $data['payment_timestamp'] = strtotime(date("m/d/Y"));
            $data['payment_type'] = 'paypal';
            $sale_id = $_POST['custom'];
            $vendors = $this->crud_model->vendors_in_sale($sale_id);
            $payment_status = array();
            foreach ($vendors as $p) {
                $payment_status[] = array('vendor' => $p, 'status' => 'paid');
            }
            if ($this->crud_model->is_admin_in_sale($sale_id)) {
                $payment_status[] = array('admin' => '', 'status' => 'paid');
            }
            $data['payment_status'] = json_encode($payment_status);
            $this->db->where('sale_id', $sale_id);
            $this->db->update('sale', $data);
        }
    }

    /* FUNCTION: Loads after cancelling paypal*/
    function paypal_cancel()
    {
        $sale_id = $this->session->userdata('sale_id');
        $this->db->where('sale_id', $sale_id);
        $this->db->delete('sale');
        $this->session->set_userdata('sale_id', '');
        $this->session->set_flashdata('alert', 'payment_cancel');
        redirect(base_url() . 'index.php/home/cart_checkout/', 'refresh');
    }

    /* FUNCTION: Loads after successful paypal payment*/
    function paypal_success()
    {
        $carted = $this->cart->contents();
        $sale_id = $this->session->userdata('sale_id');
        foreach ($carted as $value) {
            $this->crud_model->decrease_quantity($value['id'], $value['qty']);
            $data1['type'] = 'destroy';
            $data1['category'] = $this->db->get_where('product', array(
                'product_id' => $value['id']
            ))->row()->category;
            $data1['sub_category'] = $this->db->get_where('product', array(
                'product_id' => $value['id']
            ))->row()->sub_category;
            $data1['product'] = $value['id'];
            $data1['quantity'] = $value['qty'];
            $data1['total'] = 0;
            $data1['reason_note'] = 'sale';
            $data1['sale_id'] = $sale_id;
            $data1['datetime'] = time();
            $this->db->insert('stock', $data1);
        }
        $this->cart->destroy();
        $this->session->set_userdata('couponer', '');
        $this->crud_model->email_invoice($sale_id);
        $this->session->set_userdata('sale_id', '');
        redirect(base_url() . 'index.php/home/invoice/' . $sale_id, 'refresh');
    }


    /* FUNCTION: Concerning wishlist*/
    function wishlist($para1 = "", $para2 = "")
    {
        if ($para1 == 'add') {
            $this->crud_model->add_wish($para2);
        } else if ($para1 == 'remove') {
            $this->crud_model->remove_wish($para2);
        } else if ($para1 == 'num') {
            echo $this->crud_model->wished_num();
        }

    }

    /* FUNCTION: Concerning wishlist*/
    function chat($para1 = "", $para2 = "")
    {

    }

    /* FUNCTION: Check if Customer is logged in*/
    function check_login($para1 = "")
    {
        if ($para1 == 'state') {
            if ($this->session->userdata('user_login') == 'yes') {
                echo 'hypass';
            }
            if ($this->session->userdata('user_login') !== 'yes') {
                echo 'nypose';
            }
        } else if ($para1 == 'id') {
            echo $this->session->userdata('user_id');
        } else {
            echo $this->crud_model->get_type_name_by_id('user', $this->session->userdata('user_id'), $para1);
        }
    }

    /* FUNCTION: Invoice showing*/
    function invoice($para1 = "", $para2 = "")
    {

//        if ($this->session->userdata('user_login') != "yes"
//            || (int)$this->crud_model->get_type_name_by_id('sale', $para1, 'buyer') !== (int)$this->session->userdata('user_id')) {
//            redirect(base_url(), 'refresh');
//        }

        $page_data['sale_id'] = $para1;
        $page_data['page_name'] = "invoice";
        $page_data['page_title'] = translate('invoice');
        if ($para2 == 'email') {
            $this->load->view('front/invoice_email', $page_data);
        } else {
            $this->load->view('front/index', $page_data);
        }
    }

    /* FUNCTION: Legal pages load - terms & conditions / privacy policy*/
    function legal($type = "")
    {
        $page_data['type'] = $type;
        $page_data['page_name'] = "legal";
        $page_data['page_title'] = translate($type);
        $this->load->view('front/index', $page_data);
    }

    /* FUNCTION: Price Range Load by AJAX*/
    function get_ranger($by = "", $id = "", $start = '', $end = '')
    {
        $min = $this->get_range_lvl($by, $id, "min");
        $max = $this->get_range_lvl($by, $id, "max");
        if ($start == '') {
            $start = $min;
        }
        if ($end == '') {
            $end = $max;
        }

        $return = '' . '<input type="text" id="rangelvl" value="" name="range" />' . '<script>' . '	$("#rangelvl").ionRangeSlider({' . '		hide_min_max: false,' . '		keyboard: true,' . '		min:' . $min . ',' . '		max:' . $max . ',' . '		from:' . $start . ',' . '		to:' . $end . ',' . '		type: "double",' . '		step: 1,' . '		prefix: "' . currency() . '",' . '		grid: true,' . '		onFinish: function (data) {' . "			filter('click','none','none','0');" . '		}' . '	});' . '</script>';
        return $return;
    }

    /* FUNCTION: Price Range Load by AJAX*/
    function get_range_lvl($by = "", $id = "", $type = "")
    {
        if ($type == "min") {
            $set = 'asc';
        } elseif ($type == "max") {
            $set = 'desc';
        }
        $this->db->limit(1);
        $this->db->order_by('sale_price', $set);
        if (count($a = $this->db->get_where('product', array(
                $by => $id
            ))->result_array()) > 0
        ) {
            foreach ($a as $r) {
                return $r['sale_price'];
            }
        } else {
            return 0;
        }
    }

    /* FUNCTION: AJAX loadable scripts*/
    function others($para1 = "", $para2 = "", $para3 = "", $para4 = "")
    {
        if ($para1 == "get_sub_by_cat") {
            $return = '';
            $subs = $this->db->get_where('sub_category', array(
                'category' => $para2
            ))->result_array();
            foreach ($subs as $row) {
                $return .= '<option value="' . $row['sub_category_id'] . '">' . $row['sub_category_name'] . '</option>' . "\n\r";
            }
            echo $return;
        } else if ($para1 == "get_range_by_cat") {
            if ($para2 == 0) {
                echo $this->get_ranger("product_id !=", "", $para3, $para4);
            } else {
                echo $this->get_ranger("category", $para2, $para3, $para4);
            }
        } else if ($para1 == "get_range_by_sub") {
            echo $this->get_ranger("sub_category", $para2);
        }
    }

    //SITEMAP
    function sitemap()
    {
        $otherurls = array(
            base_url() . 'index.php/home/contact/',
            base_url() . 'index.php/home/legal/terms_conditions',
            base_url() . 'index.php/home/legal/privacy_policy'
        );
        $producturls = array();
        $products = $this->db->get_where('product', array('status' => 'ok'))->result_array();
        foreach ($products as $row) {
            $producturls[] = $this->crud_model->product_link($row['product_id']);
        }
        $vendorurls = array();
        $vendors = $this->db->get_where('vendor', array('status' => 'approved'))->result_array();
        foreach ($vendors as $row) {
            $vendorurls[] = $this->crud_model->vendor_link($row['vendor_id']);
        }
        $page_data['otherurls'] = $otherurls;
        $page_data['producturls'] = $producturls;
        $page_data['vendorurls'] = $vendorurls;
        $this->load->view('front/sitemap', $page_data);
    }

    function confirm_payment($para1 = "")
    {
        // reCAPTCHA secret key
        define('SecretKey', "6Lfq3xEUAAAAALcoCTtZy_Avl9HV5wTK45-og6Ej");
        $this->load->library('form_validation');
        if ($para1 == 'confirm') {
            $safe = 'yes';
            $char = '';
            foreach ($_POST as $row) {
                if (preg_match('/[\'^":()}{#~><>|=+¬]/', $row, $match)) {
                    $safe = 'no';
                    $char = $match[0];
                }
            }

            $this->form_validation->set_rules('order_id', 'order_id', 'required');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('last_name', 'last_name', 'required');
            $this->form_validation->set_rules('payment_date', 'payment_date', 'required');
            $this->form_validation->set_rules('payment_time', 'payment_time', 'required');
            $this->form_validation->set_rules('payment_pay', 'payment_pay', 'required');

            if ($this->form_validation->run() == FALSE) {
                echo validation_errors();
            } else {
                if ($safe == 'yes') {

//                    $query_params = [
//                        'secret' => SecretKey,
//                        'response' => filter_input(INPUT_POST, 'g-recaptcha-response'),
//                        'remoteip' => $_SERVER['REMOTE_ADDR']
//                    ];
//                    $url = 'https://www.google.com/recaptcha/api/siteverify?'.http_build_query($query_params);
//                    $result = json_decode(file_get_contents($url), true);

//                    if ($result['success']) {
                        $data['order_id'] = $this->input->post('order_id');
                        $data['name'] = $this->input->post('name', true);
                        $data['last_name'] = $this->input->post('last_name');
                        $data['payment_date'] = $this->input->post('payment_date');
                        $data['payment_time'] = $this->input->post('payment_time');
                        $data['payment_pay'] = $this->input->post('payment_pay');
                        $data['create_date'] = date("Y-m-d H:i:s");
                        $data['active'] = 1;
                        $data['status'] = 1;
                        $data['message'] = $this->security->xss_clean(($this->input->post('message')));
                        $this->crud_model->file_up('payment_slip', 'confirm_payment', $data['order_id']);
                        $this->db->insert('confirm_payment', $data);
                        $this->session->set_userdata('confirm_payment',$data);
                        echo 'sent';
//                        redirect(base_url() . 'index.php/home/payment_success/');
//                    } else {
//                        echo "ฉันไม่ใช่โปรแกรมอัตโนมัติ";
//                    }
                } else {
                    echo 'Disallowed charecter : " ' . $char . ' " in the POST';
                }
            }
        } else {
//            $page_data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
            $page_data['page_name'] = "confirm_payment";
            $page_data['page_title'] = translate('confirm_payment');
            $this->load->view('front/index', $page_data);
        }
    }


    function payment_success($para1 = "")
    {
            $page_data['payment_success'] =  $this->session->userdata('confirm_payment');;
            $page_data['page_name'] = "payment_success";
            $page_data['page_title'] = translate('payment_success');
            $this->load->view('front/index', $page_data);

    }

    function thankyou()
    {
        $page_data['page_name'] = "thankyou";
        $page_data['page_title'] = translate('thank_you');
        $this->load->view('front/blank',$page_data);
    }



    public function gallery($para1 = "")
    {
        if ($para1==""){
            $page_data['gallery_category'] = $this->db->get('gallery_category')->result_array();
            $page_data['page_name'] = "gallery";
            $page_data['page_title'] = translate('event_&_gallery');
        }else{
            $page_data['gallery'] = $this->db->get_where('gallery', array('c_gallery_id' => $para1))->result_array();
            $page_data['gallery_category'] = $this->db->get('gallery_category')->result_array();
            $page_data['gallery_category_one'] = $this->db->get_where('gallery_category', array('c_gallery_id' => $para1))->result_array();
            $page_data['page_name'] = "gallery_view";
            $page_data['page_title'] = translate('gallery_view');
        }
        $this->load->view('front/index', $page_data);
    }
    public function hr()
    {
        $page_data['page_name'] = "hr";
        $page_data['page_title'] = translate('hr');
        $this->load->view('front/index', $page_data);
    }


    public function policies()
    {
        $page_data['policies'] = $this->db->get('policy')->result_array();
        $page_data['page_name'] = "policies";
        $page_data['page_title'] = translate('policies');
        $this->load->view('front/index', $page_data);
    }

    public function storeLocations()
    {
        $page_data['store'] = $this->db->get('store_locations')->result_array();
        $page_data['page_name'] = "storeLocations";
        $page_data['page_title'] = translate('store_locations');
        $this->load->view('front/index', $page_data);
    }
    
    function chk_postal(){
        $model =  $this->db->get_where('zipcodes', array('zipcode' => $_POST['code']))->result_array();
            foreach ($model as $pos){
                $dis = $this->db->get_where('districts', array(
                    'DISTRICT_CODE' => $pos['district_code']
                ))->row();
                $posCode[] = trim($dis->DISTRICT_NAME);
            }
            echo json_encode($posCode);
    }


    public function event_activity($para1 = "")
    {
        if ($para1==""){
            $page_data['activity'] = $this->db->get('event_activity')->result_array();
            $page_data['page_name'] = "event_activity";
            $page_data['page_title'] = translate('event_&_activity');
        }else{
            $page_data['activity'] = $this->db->get('event_activity')->result_array();
            $page_data['activity_one'] = $this->db->get_where('event_activity', array('id' => $para1))->result_array();
            $page_data['page_name'] = "event_activity_view";
            $page_data['page_title'] = translate('event_&_activity');
        }
        $this->load->view('front/index', $page_data);
    }

    public function tracking($para1="")
    {
        if ($para1=="chk") {
            $page_data['tracking'] = $this->db->get_where('sale', array('sale_code' => $_POST['tracking_text']))->row();
        }
        $page_data['page_name'] = "tracking";
        $page_data['page_title'] = translate('product_tracking');
        $this->load->view('front/index', $page_data);
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
