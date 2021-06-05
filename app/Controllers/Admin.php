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
            $query = $db->query("UPDATE peserta SET htm = 1 WHERE id = '$id'");
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