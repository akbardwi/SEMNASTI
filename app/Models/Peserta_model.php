<?php namespace App\Models;

use CodeIgniter\Model;

class Peserta_model extends Model{
    protected $table 		= 'peserta';
	protected $primaryKey 	= 'id';
    protected $allowedFields = ['nama', 'email', 'instansi', 'nim', 'category', 'hp'];

    // Listing
	public function listing(){
		$this->select('*');
		$this->orderBy("id", "ASC");
		$query = $this->get();
		return $query->getResultArray();
	}
	
	// Count
	public function category($cat){
		$this->select('*');
		$this->where(['category' => $cat]);
		$query = $this->get();
		return $query->getResultArray();
    }

	// Lunas Pembayaran
	public function lunas(){
		$this->select('*');
		$this->where(['htm' => 1]);
		$query = $this->get();
		return $query->getResultArray();
    }
    
    //Cek Email
    public function check_email($email){
        $this->select("*");
        $this->where(['email' => $email]);
        $query = $this->get();
		return $query->getRowArray();
    }

	//Tambah
	public function tambah($data){
		$this->save($data);
	}

	//Read
    public function read($id){
		$this->select('*');
		$this->where(['id' => $id]);
		$query = $this->get();
		return $query->getRowArray();
	}
}