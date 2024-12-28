<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name'     => $row[0],
            'username' => $row[1],
            'password' => bcrypt($row[2]), // Pastikan untuk mengenkripsi password
            'kelas'    => $row[3],
            'alamat'   => $row[4],
            'nis'      => $row[5],
            'status'   => $row[6],
        ]);
    }
}
