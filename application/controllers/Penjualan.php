<?php  

class Penjualan extends CI_Controller{

	public function __construct(){
		parent::__construct();
		if($this->session->userdata('hak_akses') != '2'){
			$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Anda belum login!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

				redirect('welcome');
		} else {
			$username				= $this->session->userdata('username');
			$cek_produk 			= $this->db->query("SELECT * FROM produk WHERE username = '$username'")->result();
			$cek_kas 				= $this->db->query("SELECT * FROM kas WHERE username = '$username'")->result();
			if(empty($cek_produk)){
				$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Untuk mengakses penjualan, silahkan tambahkan produk!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

				redirect('produk');
			} elseif(empty($cek_kas)) {
				$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Untuk mengakses penjualan, silahkan tambahkan kas!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

				redirect('produk');
			}
		}
	}

	public function index()
	{
		$data['title']          	= "Kasir-Un - Penjualan";
		$username					= $this->session->userdata('username');
        $data['t_penjualan']      	= $this->db->query("SELECT * FROM penjualan WHERE username = '$username'")->result();

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/penjualan',$data);
		$this->load->view('users/templates/footer');
	}
    public function tambahPenjualan(){
        $data['title']          = "Kasir-Un - Tambah Penjualan";
		$username				= $this->session->userdata('username');
		$data['t_produk']		= $this->db->query("SELECT * FROM produk WHERE username = '$username'")->result();
		$data['t_kas']			= $this->db->query("SELECT * FROM kas WHERE username = '$username'")->result();

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/tambahPenjualan',$data);
		$this->load->view('users/templates/footer');
    }
    public function tambahPenjualanAksi(){
		$this->_rules();

		if($this->form_validation->run() == FALSE){
			$this->tambahPenjualan();
		}else{
			$nama_produk 				= $this->input->post('nama_produk');
			$jumlah 					= $this->input->post('jumlah');
			$nama_kas 					= $this->input->post('nama_kas');
			$tanggal	 				= date('d-m-Y');
			$username					= $this->session->userdata('username');

			$cek_produk					= $this->db->query("SELECT * FROM produk WHERE nama_produk = '$nama_produk' && username = '$username'")->result();
			foreach($cek_produk as $cb):
				$harga_produk = $cb->harga_produk*$jumlah;
				$stok_produk  = $cb->stok_produk;
				$id_produk    = $cb->id_produk;
			endforeach;
			
			$cek_kas					= $this->db->query("SELECT * FROM kas WHERE nama_kas = '$nama_kas' && username = '$username'")->result();
			foreach($cek_kas as $ck):
				$sisa_kas 	= $ck->saldo_kas;
				$id_kas 	= $ck->id_kas;
			endforeach;

			if($jumlah > $stok_produk) {
				$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>maaf sisa produk untuk barang '.$nama_produk.' adalah '.$stok_produk.', silahkan melakukan transaksi ulang</strong> 
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

				$this->tambahPenjualan();
			} else {
				$saldo_kas 	= $sisa_kas + $harga_produk;

				$data = array(
					'nama_produk' 				=> $nama_produk,
					'id_produk' 				=> $id_produk,
					'jumlah' 					=> $jumlah,
					'nama_kas' 					=> $nama_kas,
					'id_kas' 					=> $id_kas,
					'tanggal' 					=> $tanggal,
					'username' 					=> $username,
				);
	
				$data_kas = array(
					'saldo_kas'					=> $saldo_kas
				);
				
				$where_kas = array(
					'nama_kas' 					=> $nama_kas, 
					'username' 					=> $username, 
				);

				$nama_riwayat					= 'penjualan barang';
				$deskripsi						= 'Berhasil melakukan penjualan '.$nama_produk.' sebanyak '.$jumlah.' unit dengan total harga Rp.'.$harga_produk.' dan saldo Anda '.$saldo_kas;

				$data_riwayat = array (
					'nama_riwayat'				=> $nama_riwayat,
					'deskripsi'					=> $deskripsi,
					'tanggal'					=> $tanggal,
					'username'					=> $username,
				);
	
				$this->KasirModel->insert_data($data,'penjualan');
				$this->KasirModel->update_data('kas',$data_kas,$where_kas);
				$this->KasirModel->insert_data($data_riwayat,'riwayat_update');
				$this->session->set_flashdata('pesan','<div class="alert alert-primary alert-dismissible fade show" role="alert">
					  <strong>Berhasil melalukan penjualan!</strong>
					  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>');
	
				redirect('penjualan');
			}
		}
    }
    public function editPenjualan($id){
        $data['title']          = "Kasir-Un - Edit Penjualan";
		$username				= $this->session->userdata('username');
        $data['e_penjualan']    = $this->db->query("SELECT * FROM penjualan WHERE id = '$id' && username = '$username'")->result();

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/editPenjualan',$data);
		$this->load->view('users/templates/footer');
    }
    public function editPenjualanAksi(){
		$this->_rules();

		$id 				= $this->input->post('id');

		if($this->form_validation->run() == FALSE){
			$this->editPembelian($id);
		}else{
			$nama_produk 				= $this->input->post('nama_produk');
			$nama_kas 					= $this->input->post('nama_kas');
			$jumlah 					= $this->input->post('jumlah');
			$username					= $this->session->userdata('username');

			$cek_penjualan  			= $this->db->query("SELECT * FROM penjualan WHERE id = '$id' && username = '$username'")->result();
			foreach($cek_penjualan as $cp) :
				$j_beli					= $cp->jumlah;
			endforeach;

			$cek_produk					= $this->db->query("SELECT * FROM produk WHERE nama_produk = '$nama_produk' && username = '$username'")->result();
			foreach($cek_produk as $cb) :
				$harga_produk 			= $cb->harga_produk;
			endforeach;

			$cek_kas					= $this->db->query("SELECT * FROM kas WHERE nama_kas = '$nama_kas' && username = '$username'")->result();
			foreach($cek_kas as $ck) :
				$sisa_kas 				= $ck->saldo_kas;
			endforeach;

			if($j_beli == $jumlah){
				$saldo_kas 				= $sisa_kas;
			} else if ($j_beli < $jumlah) {
				$saldo_kas 				= $sisa_kas + ($jumlah - $j_beli) * $harga_produk;
			} else {
				$saldo_kas 				= $sisa_kas - ($j_beli - $jumlah) * $harga_produk;
			}

			$data = array(
				'jumlah' 				=> $jumlah,
			);

			$where = array(
				'id'					=> $id,
				'username'				=> $username
			);

			$data_kas = array(
				'saldo_kas'				=> $saldo_kas				
			);

			$where_kas = array(
				'nama_kas'				=> $nama_kas,
				'username'				=> $username,
			);

			$this->KasirModel->update_data('penjualan',$data,$where);
			$this->KasirModel->update_data('kas',$data_kas,$where_kas);
			$this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <strong>Data berhasil diedit!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

			redirect('penjualan');
		}
    }
    public function _rules(){
		$this->form_validation->set_rules('nama_produk','Nama Produk','required');
		$this->form_validation->set_rules('jumlah','Jumlah','required');
		$this->form_validation->set_rules('nama_kas','Nama Kas','required');
    }
	public function deletePenjualanAksi($id){
		$username 			= $this->session->userdata('username');

		$cek_penjualan 		= $this->db->query("SELECT * FROM penjualan WHERE id = '$id' && username = '$username'")->result();
		foreach($cek_penjualan as $cp) :
			$j_beli  		= $cp->jumlah;
			$nama_produk	= $cp->nama_produk;
			$nama_kas		= $cp->nama_kas;
		endforeach;

		$cek_produk 		= $this->db->query("SELECT * FROM produk WHERE nama_produk = '$nama_produk' && username = '$username'")->result();
		foreach($cek_produk as $cb) :
			$harga_produk 	= $cb->harga_produk;
		endforeach;

		$cek_kas			= $this->db->query("SELECT * FROM kas WHERE nama_kas = '$nama_kas' && username = '$username'")->result();
		foreach($cek_kas as $ck) :
			$sisa_kas 		= $ck->saldo_kas;
		endforeach;

		$saldo_kas			= ($j_beli * $harga_produk) - $sisa_kas;

		$data_kas			= array(
			'saldo_kas'		=> $saldo_kas,
		);

		$where_kas 			= array(
			'nama_kas'		=> $nama_kas,
			'username'		=> $username,
		);

		$where				= array(
			'id'			=> $id,
			'username'		=> $username,
		);

		$this->KasirModel->update_data('kas',$data_kas,$where_kas);
		$this->KasirModel->delete_data($where,'penjualan');
		$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Data berhasil dihapus</strong>, Saldo telah di kembali ke Kas
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

		redirect('penjualan');
	}

}

?>