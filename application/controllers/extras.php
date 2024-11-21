<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class extras extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function splash() {
		$this->load->view('extras/splash');
	}
}