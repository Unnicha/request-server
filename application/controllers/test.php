<?php

	class test extends CI_Controller {

		public function __construct() {
			parent::__construct();
		}

		public function index() {
			$a = 'hai';
			$b = 'cantik';
			$this->kirim($a, $b);
		}

		public function kirim($a, $b='') {
			echo 'ini a = '.$a.'<br>';
			if ($b != 'kakak')
			echo 'ini b = '.$b.'<br>';
		}
	}
?>