<?php namespace App\Controllers;

// Load model
use App\Models\User_model;
use App\Models\Peserta_model;
// End load model

use App\Controllers\BaseController;

class Admin extends BaseController{
	//Konstruktor
	public function __construct(){
        helper(['form', 'url']);
        $this->form_validation = \Config\Services::validation();
    }

    public function index(){
        return redirect()->to(base_url("admin/dashboard"));
    }

    public function login(){
		$config = null;
		$session = \Config\Services::session($config);
		// Proteksi
		if($session->get('admin_user') !="") {
			return redirect()->to(base_url('admin/dashboard'));
		}
		// End proteksi
        return view("admin/login");
    }

    public function changeHTM($id){
        $config = null;
		$session = \Config\Services::session($config);
		// Proteksi
		if($session->get('admin_user') == "") {
            $session->setFlashdata('error', 'Anda belum login');
			return redirect()->to(base_url('admin/login'));
		}
		// End proteksi

        $db = \Config\Database::connect();
        $model = new Peserta_model();
        $data = $model->read($id);
        if($data == null){
            $session->setFlashdata('error', 'ID Peserta tidak ditemukan');
            return redirect()->to(base_url('admin/dashboard'));
        }
        
        if($data['htm'] == 0){
            $email = $data['email'];
            $email_smtp = \Config\Services::email();
            $email_smtp->setFrom("hmti@orma.dinus.ac.id", "HMTI UDINUS");
            $email_smtp->setTo("$email");
            $email_smtp->setSubject("Konfirmasi Pendaftaran Peserta SEMNASTI 2021");
            // $email_smtp->setMessage("<div>Halo, $nama</div><div><br /></div><div>Terimakasih telah mendaftar sebagai Peserta di acara SEMNASTI 2021. Untuk para peserta diharapkan untuk bergabung kedalam whatsapp group agar mendapatkan informasi-informasi terbaru.</div><div>Berikut link whatsapp group :</div><div><br /></div><div>(Kasih tau nggak yaa xixixi)</div><div><br /></div><div>Salam, SEMNASTI 2021</div>");
            $email_smtp->setMessage('<div>Hallo, '.$data['nama'].'</div><div><br /></div><div>Terima kasih telah melunasi administrasi untuk acara SEMNASTI 2021. Selanjutnya Anda akan mendapatkan link akses ke Zoom Meeting yang akan digunakan untuk acara SEMNASTI 2021, link akses akan kami bagikan H-1 sebelum acara, jadi pastikan email ini tetap aktif.</div><div>Jika ada pertanyaan, Anda dapat menghubungi contact person berikut:</div><div><ul style="text-align: left;"><li>Akbar - 085326629159 (WhatsApp)</li><li>Ekki - 082241698249 (WhatsApp)</li></ul><div>Terima kasih, panitia SEMNASTI 2021</div></div>');
            $kirim = $email_smtp->send();
            if($kirim){
                $query = $db->query("UPDATE peserta SET htm = 1 WHERE id = '$id'");
            }
        } else {
            $query = $db->query("UPDATE peserta SET htm = 0 WHERE id = '$id'");
        }
        
        if($query){
            $session->setFlashdata('success', 'Data berhasil diubah');
        } else {
            $session->setFlashdata('error', 'Gagal! Silahkan hubungi developer');
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    //Index
    public function dashboard(){
        helper('form');
		$config = null;
		$session = \Config\Services::session($config);
		// Proteksi
		if($session->get('admin_user') == "") {
            $session->setFlashdata('error', 'Anda belum login');
			return redirect()->to(base_url('admin/login'));
		}
		// End proteksi
        
        $model = new User_model();
        $peserta = new Peserta_model();
        $data = array(  'title'			=> 'Halaman Dashboard',
                        'user'          => $model->detail($session->get('admin_user')),
                        'peserta'       => $peserta->listing(),
                        'lunas'         => $peserta->lunas(),
                        'content'		=> 'admin/dashboard');
        return view('admin/layout/wrapper',$data);
    }
}