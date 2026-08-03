<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['nama']) || !isset($row['email'])) {
            return null;
        }

        $user = User::updateOrCreate(
            ['email' => $row['email']],
            [
                'name' => $row['nama'],
                'password' => Hash::make($row['password'] ?? 'password123'),
            ]
        );

        if (isset($row['role']) && !empty($row['role'])) {
            $user->syncRoles([$row['role']]);
        }

        return $user;
    }
}
