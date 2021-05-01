<?php namespace App\Controllers;

// Load model
use App\Models\Peserta_model;
use App\Models\User_model;
// End load model

class Auth extends BaseController{
    public function __construct(){
        helper('form', 'url');
        $this->form_validation = \Config\Services::validation();
    }

    //Proses Login Admin
    public function login(){
        $config = null;
		$session = \Config\Services::session($config);
		$model = new User_model();
		$username = filter_var($this->request->getVar('username'), FILTER_SANITIZE_STRING);
		$password = filter_var($this->request->getVar('password'), FILTER_SANITIZE_STRING);
		$login = [
            'username'  => $username,
            'password'  => $password
		];
		if($this->form_validation->run($login, 'login') == FALSE){
            // mengembalikan nilai input yang sudah dimasukan sebelumnya
            session()->setFlashdata('inputs', $this->request->getPost());
            // memberikan pesan error pada saat input data
			session()->setFlashdata('errors', $this->form_validation->getErrors());
			return redirect()->to(base_url('admin/login'));
        } else {
			$check_user = $model->check_user($username);
			if($check_user){
				if(password_verify($password, $check_user['password'])){
					// $session->set('admin_user',$username);
					$session->set('admin_user',$check_user['username']);
					// $session->set('admin_level',$check_user['akses_level']);
					// $session->set('admin_nama',$check_user['nama']);
					// Login success
					// $session->setFlashdata('sukses', 'Anda berhasil login');
					return redirect()->to(base_url('admin/dashboard'));
				} else {
					session()->setFlashdata('error', 'Password salah');
					return redirect()->to(base_url('admin/login'));
				}
			} else {
				session()->setFlashdata('error', 'Username tidak ditemukan');
				return redirect()->to(base_url('admin/login'));
			}
        }
    }

    //Proses pendaftaran
	public function registration(){
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "POST"){
			$nama = filter_var($this->request->getVar('nama'), FILTER_SANITIZE_STRING);
            $instansi = filter_var($this->request->getVar('institution'), FILTER_SANITIZE_STRING);
            $email = filter_var($this->request->getVar('email'), FILTER_SANITIZE_EMAIL);
            $hp = filter_var($this->request->getVar('hp'), FILTER_SANITIZE_NUMBER_INT);

            $model 		= new Peserta_model();
            $check_email= $model->check_email($email);
            $db      	= \Config\Database::connect();
            $peserta  	= $db->table('peserta');
            if($peserta->countAllResults() < 150){
                if($check_email){
                    session()->setFlashdata('error', 'Email sudah terdaftar');
                    return redirect()->to(base_url()."/#registration");
                } else {
                    $peserta = [
                        'nama'      => $nama,
                        'instansi'  => $instansi,
                        'email'     => $email,
                        'hp'        => $hp
                    ];
                    if($this->form_validation->run($peserta, 'peserta') == FALSE){
                        // mengembalikan nilai input yang sudah dimasukan sebelumnya
                        session()->setFlashdata('inputs', $this->request->getPost());
                        // memberikan pesan error pada saat input data
                        session()->setFlashdata('errors', $this->form_validation->getErrors());
                        return redirect()->to(base_url());
                    } else {
                        $batas = strtotime(date("24-05-2021 10:00:00"));
                        $sekarang = strtotime(date("d-m-Y H:i:s"));
                        if($batas >= $sekarang){
                            $email_smtp = \Config\Services::email();
                            $email_smtp->setFrom("hmti@orma.dinus.ac.id", "HMTI UDINUS");
                            $email_smtp->setTo("$email");
                            $email_smtp->setSubject("Konfirmasi Pendaftaran Peserta SEMNASTI 2021");
                            $email_smtp->setMessage("<div>Halo, $nama</div><div><br /></div><div>Terimakasih telah mendaftar sebagai Peserta di acara SEMNASTI 2021. Untuk para peserta diharapkan untuk bergabung kedalam whatsapp group agar mendapatkan informasi-informasi terbaru.</div><div>Berikut link whatsapp group :</div><div><br /></div><div>(Kasih tau nggak yaa xixixi)</div><div><br /></div><div>Salam, SEMNASTI 2021</div>");
                            $kirim = $email_smtp->send();
                            if($kirim){
                                $model->tambah($peserta);
                                session()->setFlashdata('success', 'Terima kasih telah mendaftar. Nantikan informasi dari kami yang akan dikirim ke email Anda.');
                                return redirect()->to(base_url()."/#registration");  
                            } else {
                                session()->setFlashdata('inputs', $this->request->getPost());
                                session()->setFlashdata('error', 'Gagal mengirim email konfirmasi, silahkan coba lagi.');
                                return redirect()->to(base_url()."/#registration");
                            }             
                        } else {
                            session()->setFlashdata('inputs', $this->request->getPost());
                            session()->setFlashdata('error', 'Mohon maaf, waktu pendaftaran sudah ditutup.');
                            return redirect()->to(base_url()."/#registration");
                        }
                    }
                }
            } else {
                session()->setFlashdata('inputs', $this->request->getPost());
                session()->setFlashdata('error', 'Mohon maaf, kuota pendaftaran sudah penuh.');
                return redirect()->to(base_url()."/#registration");
            }
		} else {
			return redirect()->to(base_url());
		}
	}
}