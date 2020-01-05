<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get_all_spa($offset, $per_page = 10, $url = '/home/spafoods',$sub='') {
		$url .= '/'.$sub;
		$sql = 'SELECT * FROM product where sub_category = "'.$sub.'" AND status = "ok"';

		$total = $this->db->query($sql)->num_rows();
		$sql .= ' Order by product_id limit '.$offset.', '.$per_page.'';
		$query = $this->db->query($sql)->result_array();

		$this->load->library('pagination');
		$data['pagination'] = $this->pagination->pagin($total, $url, $per_page);
		$data['query'] = $query;
		return $data;
	}

	function get_all_news($offset, $per_page = 10, $url = '/home/news_event',$sub='') {
		$url .= '/'.$sub;
		$sql = 'SELECT * FROM event_activity where acive = "y"';

		$total = $this->db->query($sql)->num_rows();
		$sql .= ' Order by create_date limit '.$offset.', '.$per_page.'';
		$query = $this->db->query($sql)->result_array();

		$this->load->library('pagination');
		$data['pagination'] = $this->pagination->pagin($total, $url, $per_page, 2,3);
		$data['query'] = $query;
		return $data;
	}

	function get_all_vdo($offset, $per_page = 10, $url = '/home/vdo_clips',$sub='') {
		$url .= '/'.$sub;
		$sql = 'SELECT * FROM vdo_clips where acive = "y"';

		$total = $this->db->query($sql)->num_rows();
		$sql .= ' Order by create_date limit '.$offset.', '.$per_page.'';
		$query = $this->db->query($sql)->result_array();

		$this->load->library('pagination');
		$data['pagination'] = $this->pagination->pagin($total, $url, $per_page, 2,3);
		$data['query'] = $query;
		return $data;
	}

	function get_all_health($offset, $per_page = 10, $url = '/home/health',$sub='') {
		$url .= '/'.$sub;
		$sql = 'SELECT * FROM health_corner where acive = "y"';

		$total = $this->db->query($sql)->num_rows();
		$sql .= ' Order by create_date limit '.$offset.', '.$per_page.'';
		$query = $this->db->query($sql)->result_array();

		$this->load->library('pagination');
		$data['pagination'] = $this->pagination->pagin($total, $url, $per_page, 2,3);
		$data['query'] = $query;
		return $data;
	}
}