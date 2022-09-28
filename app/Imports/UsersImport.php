<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return Model|null
    */
    public function model(array $row)
    {
        error_log(json_encode($row));
        return new User([
            'first_name' => $row['firstname'] ?? $row['name'] ?? '',
            'last_name' => $row['lastname'] ?? '',
            'middle_name' => $row['middlename'] ?? $row['middle_name'] ?? '',
            'job_position' => $row['position'] ?? $row['job_title'] ?? '',
            'email' => $row['email'] ?? $row['email2'] ?? '',
            'phone_number' => $row['phone_number'] ?? $row['phonenumber'] ?? '',
            'linkedin' => $row['linkedin'] ?? '',
            'facebook' => $row['facebook'] ?? '',
            'instagram' => $row['instagram'] ?? '',
        ]);
    }
}
