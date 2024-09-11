<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->_rules();

		if($this->form_validation->run() == FALSE){
			$data['title'] = "Form Login";
			$this->load->view('formLogin',$data);
		}else{
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$cek = $this->KasirModel->cek_login($username, $password);
			if($cek == FALSE){
				$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Password atau Username anda salah</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');
				redirect('welcome');

			}else{
				$this->session->set_userdata('hak_akses',$cek->hak_akses);
				$this->session->set_userdata('username',$cek->username);
				$this->session->set_userdata('foto',$cek->foto);

				switch ($cek->hak_akses) {
					case 1 : redirect('admin/dashboard');						
						break;
					
					case 2 : redirect('dashboard');						
						break;

					default:
						break;
				}
			}
		}
	}
	public function _rules(){
		$this->form_validation->set_rules('username','username','required');
		$this->form_validation->set_rules('password','password','required');
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('welcome');
	}
}
