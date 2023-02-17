<?php

namespace App\Database\Seeds;

use App\Entities\User;
use CodeIgniter\Database\Seeder;

class UserSeed extends Seeder
{
    public function run()
    {
        $this->db->table('auth_groups')->insertBatch([
            [ "name"        => 'admin', "description" => 'site administration'],
            [ "name"        => 'petugas', "description" => 'petugas pelayanan'],
            [ "name"        => 'pengguna', "description" => 'general user'],
        ]);
        

        // -------------------------------------------------
        $userData = new User([
            'email'         => 'int.halim@gmail.com',
            'username'      => 'admin',
            'password'      => 'admin',

            'nama'          => 'Gito',
            'tempat_lahir'  => 'Pekalongan',
            'nomor_hp'      => '081234567890',
            'tanggal_lahir' => '1991-01-01',
            'agama'         => 'islam',
            'jenis_kelamin' => 'laki-laki',
            'pekerjaan'     => 'Pengusaha',
            'alamat'        => 'Alamat Admin',
            
            'active'        => 1,
        ]);

        $userModal = new \App\Models\UserModel();
        $userModal->withGroup('admin')->save($userData);
    }
}
