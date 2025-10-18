<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManajemenUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userData = [
            'pageTitle' => 'Manajemen User',
            'pageDescription' => 'Kelola pengguna dan hak akses',
            'stats' => [
                'total_user' => 4,
                'administrator' => 1,
                'pegawai' => 3,
                'active' => 4,
                'pending' => 0
            ],
            'users' => [
                [
                    'id' => 1,
                    'name' => 'rafffahrez4',
                    'email' => 'rafffahrez4@gmail.com',
                    'role' => 'Administrator',
                    'avatar' => 'R',
                    'status' => 'active',
                    'last_login' => '2 jam yang lalu',
                    'join_date' => '15 Okt 2024',
                    'phone' => '+62 812-3456-7890',
                    'department' => 'Management'
                ],
                [
                    'id' => 2,
                    'name' => 'siti_aminah',
                    'email' => 'siti.aminah@warung.com',
                    'role' => 'Pegawai',
                    'avatar' => 'S',
                    'status' => 'active',
                    'last_login' => '5 jam yang lalu',
                    'join_date' => '10 Okt 2024',
                    'phone' => '+62 813-4567-8901',
                    'department' => 'Dapur'
                ],
                [
                    'id' => 3,
                    'name' => 'budi_santoso',
                    'email' => 'budi.santoso@warung.com',
                    'role' => 'Pegawai',
                    'avatar' => 'B',
                    'status' => 'active',
                    'last_login' => '1 hari yang lalu',
                    'join_date' => '08 Okt 2024',
                    'phone' => '+62 814-5678-9012',
                    'department' => 'Kasir'
                ],
                [
                    'id' => 4,
                    'name' => 'maya_sari',
                    'email' => 'maya.sari@warung.com',
                    'role' => 'Pegawai',
                    'avatar' => 'M',
                    'status' => 'active',
                    'last_login' => '30 menit yang lalu',
                    'join_date' => '12 Okt 2024',
                    'phone' => '+62 815-6789-0123',
                    'department' => 'Pelayanan'
                ]
            ],
            'roles' => ['Administrator', 'Pegawai', 'Manager', 'Supervisor'],
            'departments' => ['Management', 'Dapur', 'Kasir', 'Pelayanan', 'Gudang']
        ];

        return view('manajemen-user.index', compact('userData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
