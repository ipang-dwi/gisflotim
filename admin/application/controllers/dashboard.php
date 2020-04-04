<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}
	
	public function index()
	{
		$this->front_model->getStats();
		$this->session->set_userdata('option','dashboard');
		$this->load->view('dashboard.php');
	}
	
	public function user(){
		if($this->session->userdata('logged_in')!="" && $this->session->userdata('username')!="" && $this->session->userdata('password')!="" && $this->session->userdata('jt')=="admin" || $this->session->userdata('jt')=="operator"){
			$this->session->set_userdata('option','user');
			$crud = new grocery_CRUD();
			$crud->set_table('user');
			$crud->display_as('job_title','Job Title');
			$crud->set_subject('User');
			$crud->required_fields('username','password','job_title','pic','since');
			$crud->set_field_upload('pic','assets/uploads/pics');
			$crud->callback_before_insert(array($this,'encrypt_password'));
			$crud->callback_before_update(array($this,'encrypt_password'));
			if($this->session->userdata('jt')=="operator"){
				$crud->unset_add()
				 ->unset_delete()
				 ->unset_read()
				 ->unset_edit()
				 ->unset_print()
				 ->unset_export();
				$crud->columns('username','job_title','pic','since');
				$crud->fields('username','job_title','pic','since');
			}
			else
				$crud->fields('username','password','job_title','pic','since');
			$output = $crud->render();

			$this->_example_output($output);
		}
		else
			header('location:'.base_url().'');
	}
	
	public function setting(){
		if($this->session->userdata('logged_in')!="" && $this->session->userdata('username')!="" && $this->session->userdata('password')!="" && $this->session->userdata('jt')=="admin"){
			$this->session->set_userdata('option','setting');
			$crud = new grocery_CRUD();
			$crud->set_table('setting');
			$crud->set_subject('');
			$crud->unset_add()
				 ->unset_delete()
				 ->unset_print()
				 ->unset_export()
				 ->unset_read();
			$crud->display_as('desc','Deskripsi');
			$crud->display_as('nav','Logo Navigation');
			$crud->display_as('logo','Banner Admin');
			$crud->set_subject('User');
			$crud->set_relation('tema','tema','tema');
			$crud->required_fields('creator','judul','desc','logo','tema','banner1','banner2','banner3','banner4','banner5');
			$crud->set_field_upload('nav','assets/uploads/logo');
			$crud->set_field_upload('logo','assets/uploads/logo');
			$crud->set_field_upload('banner1','assets/uploads/logo');
			$crud->set_field_upload('banner2','assets/uploads/logo');
			$crud->set_field_upload('banner3','assets/uploads/logo');
			$crud->set_field_upload('banner4','assets/uploads/logo');
			$crud->set_field_upload('banner5','assets/uploads/logo');
			$crud->set_field_upload('pic1','assets/uploads/logo');
			$crud->set_field_upload('pic2','assets/uploads/logo');
			$crud->set_field_upload('pic3','assets/uploads/logo');
			$output = $crud->render();

			$this->_example_output($output);
		}
		else
			header('location:'.base_url().'');
	}
	
	public function wisata(){
		if($this->session->userdata('logged_in')!="" && $this->session->userdata('username')!="" && $this->session->userdata('password')!="" && $this->session->userdata('jt')=="admin" || $this->session->userdata('jt')=="operator"){
			$this->session->set_userdata('option','wisata');
			$crud = new grocery_CRUD();
			$crud->set_table('wisata');
			$crud->set_subject('Data Wisata');
			$crud->set_relation('id_kategori','kategori_wisata','kategori');
			$crud->display_as('id_kategori','Jenis');
			$crud->set_field_upload('pic','assets/uploads/pics/wisata');
			if($this->session->userdata('jt')=="operator"){
				$crud->unset_delete();
			}
			$output = $crud->render();

			$this->_example_output($output);
		}
		else
			header('location:'.base_url().'');
	}
	
	public function jenis(){
		if($this->session->userdata('logged_in')!="" && $this->session->userdata('username')!="" && $this->session->userdata('password')!="" && $this->session->userdata('jt')=="admin" || $this->session->userdata('jt')=="operator"){
			$this->session->set_userdata('option','jenis');
			$crud = new grocery_CRUD();
			$crud->set_table('kategori_wisata');
			$crud->set_subject('Data Jenis Wisata');
			$crud->unset_add()
				 ->unset_edit()
				 ->unset_delete();
			$output = $crud->render();

			$this->_example_output($output);
		}
		else
			header('location:'.base_url().'');
	}
	
	public function event(){
		if($this->session->userdata('logged_in')!="" && $this->session->userdata('username')!="" && $this->session->userdata('password')!="" && $this->session->userdata('jt')=="admin" || $this->session->userdata('jt')=="operator"){
			$this->session->set_userdata('option','event');
			$crud = new grocery_CRUD();
			$crud->set_table('event');
			$crud->set_subject('Data Event');
			$crud->set_field_upload('pic','assets/uploads/pics/event');
			if($this->session->userdata('jt')=="operator"){
				$crud->unset_delete();
			}
			$output = $crud->render();

			$this->_example_output($output);
		}
		else
			header('location:'.base_url().'');
	}
	
	public function profile(){
		if($this->session->userdata('logged_in')!="" && $this->session->userdata('username')!="" && $this->session->userdata('password')!=""){
			$this->session->set_userdata('option','profile');
			$crud = new grocery_CRUD();
			$crud->set_table('user');
			$crud->columns('username','job_title','pic','since');
			$crud->fields('username','pic');
			$crud->unset_add()
				 ->unset_delete()
				 ->unset_print()
				 ->unset_export()
				 ->unset_read();
			$crud->where('username',$this->session->userdata('username'));
			$crud->display_as('job_title','Job Title');
			$crud->set_subject('User');
			$crud->required_fields('username','password','pic');
			$crud->set_field_upload('pic','assets/uploads/pics');
			$crud->callback_before_update(array($this,'encrypt_password'));
			$output = $crud->render();

			$this->_example_output($output);
		}
		else
			header('location:'.base_url().'');
	}
	
	public function encrypt_password($post_array, $primary_key = null)
    {
	    $this->load->helper('security');
	    $post_array['password'] = do_hash($post_array['password'].'@adDunyaa2$MataaAdDunyaa%4#AlMarAtus91Sholihah', 'md5');
	    return $post_array;
    }
	
	public function _example_output($output = null)
	{
		$this->load->view('lte.php',$output);
	}
	
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */