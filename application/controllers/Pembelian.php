<?php  

class Pembelian extends CI_Controller{

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
			$cek_produk 			= $this->db->query("SELECT * FROM bahan WHERE username = '$username'")->result();
			$cek_kas 				= $this->db->query("SELECT * FROM kas WHERE username = '$username'")->result();
			if(empty($cek_produk)){
				$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Untuk mengakses pembelian, silahkan tambahkan bahan!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

				redirect('bahan');
			} elseif(empty($cek_kas)) {
				$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Untuk mengakses pembelian, silahkan tambahkan kas!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

				redirect('bahan');
			}
		}
	}

	public function index()
	{
		$data['title']          	= "Kasir-Un - Pembelian";
		$username					= $this->session->userdata('username');
        $data['t_pembelian']      	= $this->db->query("SELECT * FROM pembelian WHERE username = '$username'")->result();

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/pembelian',$data);
		$this->load->view('users/templates/footer');
	}
    public function tambahPembelian(){
        $data['title']          = "Kasir-Un - Tambah Pembelian";
		$username				= $this->session->userdata('username');
		$data['t_bahan']		= $this->db->query("SELECT * FROM bahan WHERE username = '$username'")->result();
		$data['t_kas']			= $this->db->query("SELECT * FROM kas WHERE username = '$username'")->result();

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/tambahPembelian',$data);
		$this->load->view('users/templates/footer');
    }
    public function tambahPembelianAksi(){
		$this->_rules();

		if($this->form_validation->run() == FALSE){
			$this->tambahPembelian();
		}else{
			$nama_bahan 				= $this->input->post('nama_bahan');
			$jumlah 					= $this->input->post('jumlah');
			$nama_kas 					= $this->input->post('nama_kas');
			$tanggal	 				= date('d-m-Y');
			$username					= $this->session->userdata('username');

			$cek_bahan					= $this->db->query("SELECT * FROM bahan WHERE nama_bahan = '$nama_bahan' && username = '$username'")->result();
			foreach($cek_bahan as $cb):
				$harga_bahan = $cb->harga_bahan*$jumlah;
			endforeach;
			
			$cek_kas					= $this->db->query("SELECT * FROM kas WHERE nama_kas = '$nama_kas' && username = '$username'")->result();
			foreach($cek_kas as $ck):
				$sisa_kas = $ck->saldo_kas;
			endforeach;

			if($harga_bahan > $sisa_kas) {
				$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				Saldo kas <strong>"'.$nama_kas.'"</strong> tidak mencukupi untuk melakukan transaksi <b>'.$jumlah.'</b> unit! Saldo Anda saat ini Rp.<i>'.$sisa_kas.'</i> dan transaksi anda sebesar Rp.'.$harga_bahan.'  
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

				$this->tambahPembelian();
			} else {
				$saldo_kas = $sisa_kas - $harga_bahan;

				$data = array(
					'nama_bahan' 				=> $nama_bahan,
					'jumlah' 					=> $jumlah,
					'nama_kas' 					=> $nama_kas,
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

				$nama_riwayat					= 'pemebelian barang';
				$deskripsi						= 'Berhasil melakukan pembelian '.$nama_bahan.' sebanyak '.$jumlah.' unit dengan total harga Rp.'.$harga_bahan.' dan sisa saldo Anda '.$saldo_kas;

				$data_riwayat = array (
					'nama_riwayat'				=> $nama_riwayat,
					'deskripsi'					=> $deskripsi,
					'tanggal'					=> $tanggal,
					'username'					=> $username,
				);
	
				$this->KasirModel->insert_data($data,'pembelian');
				$this->KasirModel->update_data('kas',$data_kas,$where_kas);
				$this->KasirModel->insert_data($data_riwayat,'riwayat_update');
				$this->session->set_flashdata('pesan','<div class="alert alert-primary alert-dismissible fade show" role="alert">
					  <strong>Berhasil melalukan pembelian!</strong>
					  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>');
	
				redirect('pembelian');
			}
		}
    }
    public function editPembelian($id){
        $data['title']          = "Kasir-Un - Edit Pembelian";
		$username				= $this->session->userdata('username');
        $data['e_pembelian']    = $this->db->query("SELECT * FROM pembelian WHERE id = '$id' && username = '$username'")->result();

		$this->load->view('users/templates/header',$data);
		$this->load->view('users/templates/sidebar');
		$this->load->view('users/editPembelian',$data);
		$this->load->view('users/templates/footer');
    }
    public function editPembelianAksi(){
		$this->_rules();

		$id 				= $this->input->post('id');

		if($this->form_validation->run() == FALSE){
			$this->editPembelian($id);
		}else{
			$nama_bahan 				= $this->input->post('nama_bahan');
			$nama_kas 					= $this->input->post('nama_kas');
			$jumlah 					= $this->input->post('jumlah');
			$username					= $this->session->userdata('username');

			$cek_pembelian  			= $this->db->query("SELECT * FROM pembelian WHERE id = '$id' && username = '$username'")->result();
			foreach($cek_pembelian as $cp) :
				$j_beli					= $cp->jumlah;
			endforeach;

			$cek_bahan					= $this->db->query("SELECT * FROM bahan WHERE nama_bahan = '$nama_bahan' && username = '$username'")->result();
			foreach($cek_bahan as $cb) :
				$harga_bahan 				= $cb->harga_bahan;
			endforeach;

			$cek_kas					= $this->db->query("SELECT * FROM kas WHERE nama_kas = '$nama_kas' && username = '$username'")->result();
			foreach($cek_kas as $ck) :
				$sisa_kas 				= $ck->saldo_kas;
			endforeach;

			if($j_beli == $jumlah){
				$saldo_kas 				= $sisa_kas;
			} else if ($j_beli < $jumlah) {
				$saldo_kas 				= $sisa_kas - ($jumlah - $j_beli) * $harga_bahan;
			} else {
				$saldo_kas 				= $sisa_kas + ($j_beli - $jumlah) * $harga_bahan;
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

			$this->KasirModel->update_data('pembelian',$data,$where);
			$this->KasirModel->update_data('kas',$data_kas,$where_kas);
			$this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <strong>Data berhasil diedit!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

			redirect('pembelian');
		}
    }
    public function _rules(){
		$this->form_validation->set_rules('nama_bahan','Nama Bahan','required');
		$this->form_validation->set_rules('jumlah','Jumlah','required');
		$this->form_validation->set_rules('nama_kas','Nama Kas','required');
    }
	public function deletePembelianAksi($id){
		$username 			= $this->session->userdata('username');

		$cek_pembelian 		= $this->db->query("SELECT * FROM pembelian WHERE id = '$id' && username = '$username'")->result();
		foreach($cek_pembelian as $cp) :
			$j_beli  		= $cp->jumlah;
			$nama_bahan		= $cp->nama_bahan;
			$nama_kas		= $cp->nama_kas;
		endforeach;

		$cek_bahan 			= $this->db->query("SELECT * FROM bahan WHERE nama_bahan = '$nama_bahan' && username = '$username'")->result();
		foreach($cek_bahan as $cb) :
			$harga_bahan 	= $cb->harga_bahan;
		endforeach;

		$cek_kas			= $this->db->query("SELECT * FROM kas WHERE nama_kas = '$nama_kas' && username = '$username'")->result();
		foreach($cek_kas as $ck) :
			$sisa_kas 		= $ck->saldo_kas;
		endforeach;

		$saldo_kas			= ($j_beli * $harga_bahan) + $sisa_kas;

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
		$this->KasirModel->delete_data($where,'pembelian');
		$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Data berhasil dihapus</strong>, Saldo telah di kembali ke Kas
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

		redirect('pembelian');
	}

}

?>