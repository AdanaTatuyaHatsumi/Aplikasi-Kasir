<?php  

class Produk extends CI_Controller{

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
		$data['title']          = "Kasir-Un - Produk";
		$username 				= $this->session->userdata('username'); 
        $data['t_produk']      	= $this->db->query("SELECT * FROM produk WHERE username = '$username'")->result();

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/produk',$data);
		$this->load->view('users/templates/footer');
	}
    public function tambahProduk(){
        $data['title']          = "Kasir-Un - Tambah Produk";

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/tambahProduk',$data);
		$this->load->view('users/templates/footer');
    }
    public function tambahProdukAksi(){
		$username 					= $this->session->userdata('username');
		$nama_produk 				= str_replace(' ','-',$this->input->post('nama_produk'));
		$id_produk					= substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'),0,60);
		$cek_produk					= $this->db->query("SELECT * FROM produk WHERE username = '$username'")->result();
		if(!empty($cek_produk)){
			$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Nama produk sudah ada!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

			$this->tambahProduk();
		} else {
			$this->_rules();

			if($this->form_validation->run() == FALSE){
				$this->tambahProduk();
			}else{
				$harga_produk 				= $this->input->post('harga_produk');
				$tanggal	 				= date('d-m-Y');
				$foto_produk 				= $_FILES['foto_produk']['name'];
				if($foto_produk=''){}else{
					$config['upload_path'] 	= './assets/foto_produk';
					$config['allowed_types'] = 'jpg|jpeg|png|tiff';
					$this->load->library('upload',$config);
					if(!$this->upload->do_upload('foto_produk')){
						echo "Foto Gagal diupload!";
					}else{
						$foto_produk = $this->upload->data('file_name');
					}
				}
				$stok_produk 				= $this->input->post('stok_produk'); 

				$data = array(
					'id_produk'					=> $id_produk,
					'nama_produk' 				=> $nama_produk,
					'harga_produk' 				=> $harga_produk,
					'tanggal' 					=> $tanggal,
					'foto_produk' 				=> $foto_produk,
					'stok_produk' 				=> $stok_produk,
					'username' 					=> $username,
				);

				$this->KasirModel->insert_data($data,'produk');
				$this->session->set_flashdata('pesan','<div class="alert alert-primary alert-dismissible fade show" role="alert">
					<strong>Data berhasil ditambahkan!</strong>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>');

				redirect('produk');
			}
		}
    }
    public function editProduk($id){
        $data['title']          	= "Kasir-Un - Edit Produk";
		$username 					= $this->session->userdata('username'); 
        $data['e_produk']      		= $this->db->query("SELECT * FROM produk WHERE id = '$id' && username = '$username'")->result();

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/editProduk',$data);
		$this->load->view('users/templates/footer');
    }
    public function editProdukAksi(){
		$this->_rules();

		$id 				= $this->input->post('id');

		if($this->form_validation->run() == FALSE){
			$this->editProduk($id);
		}else{
			$username 					= $this->session->userdata('username');
			$id_produk 					= $this->input->post('id_produk');
			$nama_produk 				= str_replace(' ','-',$this->input->post('nama_produk'));
			$harga_produk 				= $this->input->post('harga_produk');
			$tanggal	 				= date('d-m-Y');
			$foto_produk 				= $_FILES['foto_produk']['name'];
			if($foto_produk='' or !$foto_produk=''){
				$config['upload_path'] 	= './assets/foto_produk';
				$config['allowed_types'] = 'jpg|jpeg|png|tiff';
				$this->load->library('upload',$config);
				if($this->upload->do_upload('foto_produk')){
					$foto_produk = $this->upload->data('file_name');
					$this->db->set('foto_produk',$foto_produk);
				}
			}
			$stok_produk 				= $this->input->post('stok_produk');
			 

			$data = array(
				'nama_produk' 				=> $nama_produk,
				'harga_produk' 				=> $harga_produk,
				'tanggal' 					=> $tanggal,
				'stok_produk' 				=> $stok_produk,
			);

			$where = array(
				'id'						=> $id,
				'username'					=> $username,
			);

			$data_penjualan	 = array(
				'nama_produk'				=> $nama_produk,
			);

			$where_penjualan = array(
				'id_produk'					=> $id_produk,
				'username'					=> $username,
			);

			$this->KasirModel->update_data('produk',$data,$where);
			$this->KasirModel->update_data('penjualan',$data_penjualan,$where_penjualan);
			$this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <strong>Data berhasil diedit!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

			redirect('produk');
		}
    }
    public function _rules(){
		$this->form_validation->set_rules('nama_produk','Nama Produk','required');
		$this->form_validation->set_rules('harga_produk','Harga Produk','required');
		$this->form_validation->set_rules('stok_produk','Stok Produk','required');
    }
	public function deleteProdukAksi($id){
		$username 					= $this->session->userdata('username');
		$where = array(
			'id' 				=> $id,
			'username' 			=> $username,
		);

		$cek_produk 	= $this->db->query("SELECT * FROM produk WHERE id = '$id'")->result();
		foreach($cek_produk as $cp) :
			$id_produk  = $cp->id_produk;
		endforeach;	

		$where_penjualan = array(
			'id_produk'			=> $id_produk,
			'username'			=> $username,
		);

		//$cek_penjualan 		= $this->db->query("SELECT * FROM penjualan WHERE id_produk = '$id_produk' && username = '$username'")->result();
		//foreach($cek_penjualan as $cp) :
		//	$j_beli  		= $cp->jumlah;
		//	$nama_produk	= $cp->nama_produk;
		//	$nama_kas		= $cp->nama_kas;
		//endforeach;

		//$cek_produk 		= $this->db->query("SELECT * FROM produk WHERE nama_produk = '$nama_produk' && username = '$username'")->result();
		//foreach($cek_produk as $cb) :
		//	$harga_produk 	= $cb->harga_produk;
		//endforeach;

		//$cek_kas			= $this->db->query("SELECT * FROM kas WHERE nama_kas = '$nama_kas' && username = '$username'")->result();
		//foreach($cek_kas as $ck) :
		//	$sisa_kas 		= $ck->saldo_kas;
		//endforeach;

		//$saldo_kas			= ($j_beli * $harga_produk) - $sisa_kas;

		//$data_kas			= array(
		//	'saldo_kas'		=> $saldo_kas,
		//);

		//$where_kas 			= array(
		//	'nama_kas'		=> $nama_kas,
		//	'username'		=> $username,
		//);

		$this->KasirModel->delete_data($where,'produk');
		$this->KasirModel->delete_data($where_penjualan,'penjualan');
		$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Data berhasil dihapus</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

		redirect('produk');
	}

}

?>