<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;

class Admin extends BaseController
{
    protected $userModel;
    protected $aduanModel;

    protected $tmbhAduan;
    protected $informasi;

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
        $this->aduanModel = new \App\Models\AduanModel();

        $route = Services::routes();
        $this->tmbhAduan = array_key_exists('admin/aduan/add', $route->getRoutes());
        $this->informasi = array_key_exists('admin/informasi', $route->getRoutes());
    }

    public function index()
    {
        return redirect()->to(base_url('admin/home'));
    }

    public function home()
    {
        return view('home', [
            'segments' => $this->request->uri->getSegments(),
            'pengguna' => $this->userModel->withGroup("pengguna")->findAll(),
            'aduan' => $this->aduanModel->findAll(),
            'aduan_terbaru' => $this->aduanModel->where('DATE(tanggal)', date('Y-m-d'))->findAll(),
            'tahun' => $this->aduanModel->select('YEAR(tanggal) as tahun')->groupBy('YEAR(tanggal)')->orderBy('YEAR(tanggal)', 'DESC')->findAll(),
            'tambah_aduan' => $this->tmbhAduan,
            'informasi' => $this->informasi,
        ]);
    }

    public function profile()
    {
        return view('profile', [
            'segments' => $this->request->uri->getSegments(),
            'me' => $this->userModel->find(user_id()),
            
            'aduanku' => $this->aduanModel->where('user_id', user_id())->findAll(),
            'aduanku_terbaru' => $this->aduanModel->where(['user_id' => user_id()])->orderBy('tanggal', 'DESC')->findAll(3),
            'aduan_terbaru' => $this->aduanModel->where(['DATE(tanggal)' => date('Y-m-d'), 'user_id' => user_id()])->findAll(),
            
            'tambah_aduan' => $this->tmbhAduan,
            'informasi' => $this->informasi,
        ]);
    }

    public function aduan()
    {
        return view('aduan', [
            'segments' => $this->request->uri->getSegments(),
            'users' => $this->userModel->findAll(),
            'aduan' => $this->aduanModel->orderBy('tanggal', "DESC")->findAll(),
            'agent' => $this->request->getUserAgent(),
            'tambah_aduan' => $this->tmbhAduan,
            'informasi' => $this->informasi,
        ]);
    }

    public function aduan_add()
    {
        return view('aduan_add', [
            'segments' => $this->request->uri->getSegments(),
            'users' => $this->userModel->findAll(),
            'aduan' => $this->aduanModel->orderBy('tanggal', "DESC")->findAll(),
            'agent' => $this->request->getUserAgent(),
            'tambah_aduan' => $this->tmbhAduan,
            'informasi' => $this->informasi,
        ]);
    }

    public function user()
    {
        $data = [
            'title' => 'User',
            'segments' => $this->request->uri->getSegments(),
            'users' => $this->userModel->findAll(),
            'tambah_aduan' => $this->tmbhAduan,
            'informasi' => $this->informasi,
        ];

        return view('user', $data);
    }

    public function user_show()
    {
        return $this->response->setJSON(
            $this->userModel->select(
                [
                    'nama', 'username', 'email',
                    'jenis_kelamin', 'pekerjaan',
                    'alamat', 'tanggal_lahir'
                ]
            )->findAll()
        );
    }
}
