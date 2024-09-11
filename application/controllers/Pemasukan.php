<?php  

class Pemasukan extends CI_Controller{

	public function __construct(){
		parent::__construct();
		if($this->session->userdata('hak_akses') != '2'){

			$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Anda belum login</strong>
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>');
				redirect('welcome');
		} else {
			$username				= $this->session->userdata('username');
			$cek_kas 				= $this->db->query("SELECT * FROM kas WHERE username = '$username'")->result();
			if(empty($cek_kas)) {
				$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Untuk mengakses pemasukan, silahkan tambahkan kas!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

				redirect('pemasukan');
			}
		}
	}

	public function index()
	{
		$data['title']          = "Kasir-Un - Pemasukan";
		$username				= $this->session->userdata('username');
        $data['t_pemasukan']    = $this->db->query("SELECT * FROM pemasukan WHERE username = '$username'")->result();

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/pemasukan',$data);
		$this->load->view('users/templates/footer');
	}
    public function tambahPemasukan(){
        $data['title']          = "Kasir-Un - Tambah Pemasukan";
		$username				= $this->session->userdata('username');
        $data['t_kas']    		= $this->db->query("SELECT * FROM kas WHERE username = '$username'")->result();

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/tambahPemasukan',$data);
		$this->load->view('users/templates/footer');
    }
    public function tambahPemasukanAksi(){
		$this->_rules();

		if($this->form_validation->run() == FALSE){
			$this->tambahPemasukan();
		}else{
			$nama_pemasukan 		= $this->input->post('nama_pemasukan');
			$jumlah 				= $this->input->post('jumlah');
			$nama_kas 				= $this->input->post('nama_kas');
			$tanggal	 			= date('d-m-Y');
			$username				= $this->session->userdata('username');

			$cek_kas				= $this->db->query("SELECT * FROM kas WHERE nama_kas = '$nama_kas' && username = '$username'")->result();
			foreach($cek_kas as $ck) :
				$saldo_kas 			= $ck->saldo_kas + $jumlah;
			endforeach;

			$data = array(
				'nama_pemasukan' 			=> $nama_pemasukan,
				'jumlah' 					=> $jumlah,
				'nama_kas' 					=> $nama_kas,
				'tanggal' 					=> $tanggal,
				'username' 					=> $username,
			);

			$data_kas = array(
				'saldo_kas'					=> $saldo_kas
			);

			$where_kas = array(
				'nama_kas'					=> $nama_kas,
				'username'					=> $username
			);

			$this->KasirModel->insert_data($data,'pemasukan');
			$this->KasirModel->update_data('kas',$data_kas,$where_kas);
			$this->session->set_flashdata('pesan','<div class="alert alert-primary alert-dismissible fade show" role="alert">
				  <strong>Data berhasil ditambahkan!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

			redirect('pemasukan');
		}
    }
    public function editPemasukan($id){
        $data['title']          = "Kasir-Un - Edit Pemasukan";
		$username				= $this->session->userdata('username');
        $data['e_pemasukan']    = $this->db->query("SELECT * FROM pemasukan WHERE id = '$id' && username = '$username'")->result();

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/editPemasukan',$data);
		$this->load->view('users/templates/footer');
    }
    public function editPemasukanAksi(){
		$this->_rules();

		$id 				= $this->input->post('id');

		if($this->form_validation->run() == FALSE){
			$this->editPemasukan($id);
		}else{
			$nama_pemasukan 			= $this->input->post('nama_pemasukan');
			$saldo_kas 					= $this->input->post('saldo_kas');
			$tanggal	 				= date('d-m-Y');
			$username					= $this->session->userdata('username');

			$data = array(
				'nama_pemasukan' 			=> $nama_pemasukan,
				'saldo_kas' 				=> $saldo_kas,
				'tanggal' 					=> $tanggal,
			);

			$where = array(
				'id'						=> $id,
				'username'					=> $username,
			);

			$this->KasirModel->update_data('pemasukan',$data,$where);
			$this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <strong>Data berhasil diedit!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

			redirect('pemasukan');
		}
    }
    public function _rules(){
		$this->form_validation->set_rules('nama_pemasukan','Nama Pemasukan','required');
		$this->form_validation->set_rules('jumlah','Jumlah','required');
		$this->form_validation->set_rules('nama_kas','Nama Kas','required');
    }
	public function deletePemasukanAksi($id){
		$username					= $this->session->userdata('username');

		$cek_pemasukan				= $this->db->query("SELECT * FROM pemasukan WHERE id = '$id' && username = '$username'")->result();
		foreach($cek_pemasukan as $cp) :
			$nama_kas				= $cp->nama_kas;
			$jumlah 				= $cp->jumlah;
		endforeach;

		$cek_kas 					= $this->db->query("SELECT * FROM kas WHERE nama_kas = '$nama_kas' && username = '$username'")->result();
		foreach($cek_kas as $ck) :
			$saldo_kas				= $ck->saldo_kas;
		endforeach;

		$sia_kas					= $saldo_kas - $jumlah;

		$data_kas = array(
			'saldo_kas'				=> $sia_kas,
		);

		$where_kas = array(
			'id'					=> $id,
			'username'				=> $username,
		);
		
		$where = array(
			'id' 				=> $id,
			'username' 			=> $username,
		);
		$this->KasirModel->delete_data($where,'pemasukan');
		$this->KasirModel->update_data('kas',$data_kas,$where_kas);
		$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Data berhasil dihapus</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

		redirect('pemasukan');
	}

}

?>