<?php  

class Bahan extends CI_Controller{

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
		$data['title']          = "Kasir-Un - Bahan";
		$username				= $this->session->userdata('username');
        $data['t_bahan']        = $this->db->query("SELECT * FROM bahan WHERE username = '$username'")->result();

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/bahan',$data);
		$this->load->view('users/templates/footer');
	}
    public function tambahBahan(){
        $data['title']          = "Kasir-Un - Tambah Bahan";

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/tambahBahan',$data);
		$this->load->view('users/templates/footer');
    }
    public function tambahBahanAksi(){
		$this->_rules();

		if($this->form_validation->run() == FALSE){
			$this->tambahBahan();
		}else{
			$id_bahan					= substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'),0,60);
			$nama_bahan 				= str_replace(' ','-',$this->input->post('nama_bahan'));
			$harga_bahan 				= $this->input->post('harga_bahan');
			$tanggal	 				= date('d-m-Y');
			$foto_bahan 				= $_FILES['foto_bahan']['name'];
			if($foto_bahan=''){}else{
				$config['upload_path'] 	= './assets/foto_bahan';
				$config['allowed_types'] = 'jpg|jpeg|png|tiff';
				$this->load->library('upload',$config);
				if(!$this->upload->do_upload('foto_bahan')){
					echo "Foto Gagal diupload!";
				}else{
					$foto_bahan = $this->upload->data('file_name');
				}
			}
			$username				= $this->session->userdata('username');

			$data = array(
				'id_bahan' 					=> $id_bahan,
				'nama_bahan' 				=> $nama_bahan,
				'harga_bahan' 				=> $harga_bahan,
				'tanggal' 					=> $tanggal,
				'foto_bahan' 				=> $foto_bahan,
				'username' 					=> $username,
			);

			$this->KasirModel->insert_data($data,'bahan');
			$this->session->set_flashdata('pesan','<div class="alert alert-primary alert-dismissible fade show" role="alert">
				  <strong>Data berhasil ditambahkan!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

			redirect('bahan');
		}
    }
    public function editBahan($id){
        $data['title']          = "Kasir-Un - Edit Bahan";
		$username				= $this->session->userdata('username');
        $data['e_bahan']      	= $this->db->query("SELECT * FROM bahan WHERE id = '$id' && username = '$username'")->result();

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/editBahan',$data);
		$this->load->view('users/templates/footer');
    }
    public function editBahanAksi(){
		$this->_rules();

		$id 				= $this->input->post('id');

		if($this->form_validation->run() == FALSE){
			$this->editBahan($id);
		}else{
			$nama_bahan 				= str_replace(' ','-',$this->input->post('nama_bahan'));
			$harga_bahan 				= $this->input->post('harga_bahan');
			$tanggal	 				= date('d-m-Y');
			$foto_bahan 				= $_FILES['foto_bahan']['name'];
			if($foto_bahan='' or !$foto_bahan=''){
				$config['upload_path'] 	= './assets/foto_bahan';
				$config['allowed_types'] = 'jpg|jpeg|png|tiff';
				$this->load->library('upload',$config);
				if($this->upload->do_upload('foto_bahan')){
					$foto_bahan = $this->upload->data('file_name');
					$this->db->set('foto_bahan',$foto_bahan);
				}
			}
			$username				= $this->session->userdata('username');

			$data = array(
				'nama_bahan' 				=> $nama_bahan,
				'harga_bahan' 				=> $harga_bahan,
				'tanggal' 					=> $tanggal,
			);

			$where = array(
				'id'						=> $id,
				'username'					=> $username,
			);

			$this->KasirModel->update_data('bahan',$data,$where);
			$this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <strong>Data berhasil diedit!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

			redirect('bahan');
		}
    }
    public function _rules(){
		$this->form_validation->set_rules('nama_bahan','Nama Bahan','required');
		$this->form_validation->set_rules('harga_bahan','Harga Bahan','required');
    }
	public function deleteBahanAksi($id){
		$username				= $this->session->userdata('username');
		$where = array(
			'id' 			=> $id,
			'username' 		=> $username,
		);
		$this->KasirModel->delete_data($where,'bahan');
		$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Data berhasil dihapus</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

		redirect('bahan');
	}

}

?>