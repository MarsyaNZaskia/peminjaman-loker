<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name'        => $row['nama'],       // Sesuaikan dengan header di Excel
            'username'    => $row['username'],
            'email'       => ($row['email'] == '-') ? null : $row['email'], 
            'password'    => Hash::make($row['password']),
            'role'        => strtolower($row['role']),
            'kategori_id' => ($row['kategori_id'] == '-') ? null : $row['kategori_id'],
            'phone'       => $row['phone'] ?? null,
            'address'     => $row['address'] ?? null,
        ]);
    }
}
