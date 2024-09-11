<?php  

class Pengeluaran extends CI_Controller{

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
				  <strong>Untuk mengakses pengeluaran, silahkan tambahkan kas!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

				redirect('pengeluaran');
			}
		}
	}

	public function index(){
		$data['title']          	= "Kasir-Un - Pengeluaran";
		$username					= $this->session->userdata('username');
        $data['t_pengeluaran']    	= $this->db->query("SELECT * FROM pengeluaran WHERE username = '$username'")->result();

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/pengeluaran',$data);
		$this->load->view('users/templates/footer');
	}
    public function tambahPengeluaran(){
        $data['title']          = "Kasir-Un - Tambah Pengeluaran";
		$username				= $this->session->userdata('username');
        $data['t_kas']    		= $this->db->query("SELECT * FROM kas WHERE username = '$username'")->result();

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/tambahPengeluaran',$data);
		$this->load->view('users/templates/footer');
    }
    public function tambahPengeluaranAksi(){
		$this->_rules();

		if($this->form_validation->run() == FALSE){
			$this->tambahPengeluaran();
		}else{
			$nama_pengeluaran 		= $this->input->post('nama_pengeluaran');
			$jumlah 				= $this->input->post('jumlah');
			$nama_kas 				= $this->input->post('nama_kas');
			$tanggal	 			= date('d-m-Y');
			$username				= $this->session->userdata('username');

			$cek_kas				= $this->db->query("SELECT * FROM kas WHERE nama_kas = '$nama_kas' && username = '$username'")->result();
			foreach($cek_kas as $ck) :
				$saldo_kas 			= $ck->saldo_kas - $jumlah;
			endforeach;

			$data = array(
				'nama_pengeluaran' 			=> $nama_pengeluaran,
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

			$this->KasirModel->insert_data($data,'pengeluaran');
			$this->KasirModel->update_data('kas',$data_kas,$where_kas);
			$this->session->set_flashdata('pesan','<div class="alert alert-primary alert-dismissible fade show" role="alert">
				  <strong>Data berhasil ditambahkan!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

			redirect('pengeluaran');
		}
    }
    public function editPengeluaran($id){
        $data['title']          = "Kasir-Un - Edit pengeluaran";
		$username				= $this->session->userdata('username');
        $data['e_pengeluaran']    = $this->db->query("SELECT * FROM pengeluaran WHERE id = '$id' && username = '$username'")->result();

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/editPengeluaran',$data);
		$this->load->view('users/templates/footer');
    }
    public function editPengeluaranAksi(){
		$this->_rules();

		$id 				= $this->input->post('id');

		if($this->form_validation->run() == FALSE){
			$this->editPengeluaran($id);
		}else{
			$nama_pengeluaran 			= $this->input->post('nama_pengeluaran');
			$saldo_kas 					= $this->input->post('saldo_kas');
			$tanggal	 				= date('d-m-Y');
			$username					= $this->session->userdata('username');

			$data = array(
				'nama_pengeluaran' 			=> $nama_pengeluaran,
				'saldo_kas' 				=> $saldo_kas,
				'tanggal' 					=> $tanggal,
			);

			$where = array(
				'id'						=> $id,
				'username'					=> $username,
			);

			$this->KasirModel->update_data('pengeluaran',$data,$where);
			$this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <strong>Data berhasil diedit!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

			redirect('pengeluaran');
		}
    }
    public function _rules(){
		$this->form_validation->set_rules('nama_pengeluaran','Nama Pengeluaran','required');
		$this->form_validation->set_rules('jumlah','Jumlah','required');
		$this->form_validation->set_rules('nama_kas','Nama Kas','required');
    }
	public function deletePengeluaranAksi($id){
		$username					= $this->session->userdata('username');

		$cek_pengeluaran				= $this->db->query("SELECT * FROM pengeluaran WHERE id = '$id' && username = '$username'")->result();
		foreach($cek_pengeluaran as $cp) :
			$nama_kas				= $cp->nama_kas;
			$jumlah 				= $cp->jumlah;
		endforeach;

		$cek_kas 					= $this->db->query("SELECT * FROM kas WHERE nama_kas = '$nama_kas' && username = '$username'")->result();
		foreach($cek_kas as $ck) :
			$saldo_kas				= $ck->saldo_kas;
		endforeach;

		$sia_kas					= $saldo_kas + $jumlah;

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
		$this->KasirModel->delete_data($where,'pengeluaran');
		$this->KasirModel->update_data('kas',$data_kas,$where_kas);
		$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Data berhasil dihapus</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

		redirect('pengeluaran');
	}

}

?>