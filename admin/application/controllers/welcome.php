<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		header('location:'.base_url().'dashboard');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/front.php */