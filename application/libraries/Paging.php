<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Paging {
		protected $ci;

		function __construct() {
			$this->ci =& get_instance();
		}
		
		function main($base_url, $countData, $limit) {
			
			$config['base_url']			= $base_url;
			$config['total_rows']		= $countData;
			$config['per_page']			= $limit;
			$config['num_links']		= 5;
			$config['attributes']		= ['class' => 'page-link'];
			$config['enable_query_strings'] = true;

			$config['full_tag_open']	= '<nav><ul class="pagination justify-content-center">';
			$config['full_tag_close']	= '</ul></nav>';

			$config['first_link']		= '&laquo;';
			$config['first_tag_open']	= '<li class="page-item"><span>';
			$config['first_tag_close']	= '</span></li>';

			$config['prev_link']		= '&lsaquo;';
			$config['prev_tag_open']	= '<li class="page-item"><span>';
			$config['prev_tag_close']	= '</span></li>';
			
			$config['cur_tag_open']		= '<li class="page-item active"><a class="page-link" href="#">';
			$config['cur_tag_close']	= '</a></li>';
			
			$config['num_tag_open']		= '<li class="page-item">';
			$config['num_tag_close']	= '</li>';
			
			$config['next_link']		= '&rsaquo;';
			$config['next_tag_open']	= '<li class="page-item"><span>';
			$config['next_tag_close']	= '</span></li>';
			
			$config['last_link']		= '&raquo;';
			$config['last_tag_open']	= '<li class="page-item"><span>';
			$config['last_tag_close']	= '</span></li>';
			
			$this->ci->pagination->initialize($config);
		}
	}
?>