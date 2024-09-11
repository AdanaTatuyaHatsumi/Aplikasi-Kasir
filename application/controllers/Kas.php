<?php  

class Kas extends CI_Controller{

	public function __construct(){
		parent::__construct();
		if($this->session->userdata('hak_akses') != '2'){

			$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Anda belum login</strong>
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>');
				redirect('welcome');
		}
	}

	public function index()
	{
		$data['title']          = "Kasir-Un - Kas";
		$username				= $this->session->userdata('username');
        $data['t_kas']      	= $this->db->query("SELECT * FROM kas WHERE username = '$username'")->result();

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/kas',$data);
		$this->load->view('users/templates/footer');
	}
    public function tambahKas(){
        $data['title']          = "Kasir-Un - Tambah Kas";

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/tambahKas',$data);
		$this->load->view('users/templates/footer');
    }
    public function tambahKasAksi(){
		$this->_rules();

		if($this->form_validation->run() == FALSE){
			$this->tambahKas();
		}else{
			$username				= $this->session->userdata('username');
			$nama_kas 				= str_replace(' ','-',$this->input->post('nama_kas'));
			$cek_kas 				= $this->db->query("SELECT * FROM kas WHERE nama_kas = '$nama_kas' && username = '$username'")->result();
			if(!empty($cek_kas)){
				$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Nama kas  sudah ada!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

				$this->tambahKas();
			} else {
				$cek_kas 				= $this->db->query("SELECT * FROM kas WHERE username = '$username'")->result();
				$id_kas					= substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'),0,60);
				$saldo_kas 				= $this->input->post('saldo_kas');
				$tanggal	 			= date('d-m-Y');
				

				$data = array(
					'nama_kas' 					=> $nama_kas,
					'id_kas' 					=> $id_kas,
					'saldo_kas' 				=> $saldo_kas,
					'tanggal' 					=> $tanggal,
					'username' 					=> $username,
				);

				$this->KasirModel->insert_data($data,'kas');
				$this->session->set_flashdata('pesan','<div class="alert alert-primary alert-dismissible fade show" role="alert">
					<strong>Data berhasil ditambahkan!</strong>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>');

				redirect('kas');
			}
		}
    }
    public function editKas($id){
        $data['title']          = "Kasir-Un - Edit Kas";
		$username				= $this->session->userdata('username');
        $data['e_kas']      	= $this->db->query("SELECT * FROM kas WHERE id = '$id' && username = '$username'")->result();

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/editKas',$data);
		$this->load->view('users/templates/footer');
    }
    public function editKasAksi(){
		$this->_rules();

		$id 				= $this->input->post('id');

		if($this->form_validation->run() == FALSE){
			$this->editKas($id);
		}else{
			$nama_kas 					= str_replace(' ','-',$this->input->post('nama_kas'));
			$saldo_kas 					= $this->input->post('saldo_kas');
			$tanggal	 				= date('d-m-Y');
			$username					= $this->session->userdata('username');

			$data = array(
				'nama_kas' 					=> $nama_kas,
				'saldo_kas' 				=> $saldo_kas,
				'tanggal' 					=> $tanggal,
			);

			$where = array(
				'id'						=> $id,
				'username'					=> $username,
			);



			$this->KasirModel->update_data('kas',$data,$where);
			$this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <strong>Data berhasil diedit!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

			redirect('kas');
		}
    }
    public function _rules(){
		$this->form_validation->set_rules('nama_kas','Nama Kas','required');
		$this->form_validation->set_rules('saldo_kas','Saldo Kas','required');
    }
	public function deleteKasAksi($id){
		$username					= $this->session->userdata('username');
		$where = array(
			'id' 				=> $id,
			'username' 			=> $username,
		);
		$this->KasirModel->delete_data($where,'kas');
		$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Data berhasil dihapus</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

		redirect('kas');
	}

}

?>