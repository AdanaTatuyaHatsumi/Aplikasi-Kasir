<?php  

class Register extends CI_Controller{

	public function index(){
		$data['title'] = "Kasir-Un - Register";

		$this->load->view('formRegister',$data);
	}
    public function registerAksi(){
        $username              = $this->input->post('username');
        $cek_user              = $this->db->query("SELECT * FROM user WHERE username = '$username'")->result();
        if(!empty($cek_user)){
            $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Username telah digunakan!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

			redirect('register');
        }else{
            $password           = $this->input->post('password');
            $repassword         = $this->input->post('repassword');
            if($password != $repassword){
                $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Password & Re-Password tidak sama</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

			    redirect('register');
            }else{
                $email           = $this->input->post('email');
                $kode            = rand('111111','999999');
                $pass            = md5($password);

				$this->session->set_userdata('username',$username);
				$this->session->set_userdata('email',$email);
				$this->session->set_userdata('password',$pass);


                $data = array(
                    'email'      => $email,      
                    'username'   => $username,
                    'password'   => $pass,      
                    'kode'       => $kode,      
                );

                $this->KasirModel->insert_data($data,'verifikasi_email');
                $this->EmailModel->email($email,$kode);

                redirect('register/verifikasi');
            }
        }    
    }
    public function Verifikasi(){
        $data['title'] = "Kasir-Un - Verifikasi";

		$this->load->view('templates/header',$data);
		$this->load->view('formVerifikasi');
		$this->load->view('templates/footer');
    }
    public function verifikasiAksi(){
        $kode               = $this->input->post('kode');

        $verifikasi_email   = $this->db->query("SELECT * FROM verifikasi_email WHERE kode = '$kode'")->result();
        if(!empty($verifikasi_email)){

        } else {
            $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Kode Salah!</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');

			    redirect('register/verifikasi');
        }
    }

}

?>