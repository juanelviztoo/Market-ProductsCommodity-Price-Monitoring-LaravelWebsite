<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function index()
    {
        // Contoh data profil developer
        $profiles = [
            [
                'name' => 'Devita Ayu Maharani',
                'nim' => 'L0122046',
                'prodi' => 'S1 - Informatika',
                'universitas' => 'Universitas Sebelas Maret',
                'foto' => 'devitaprofile.jpg',
                'description' => 'Authentication Administrator'
            ],
            [
                'name' => 'Elvizto Juan Khresnanda',
                'nim' => 'L0122054',
                'prodi' => 'S1 - Informatika',
                'universitas' => 'Universitas Sebelas Maret',
                'foto' => 'elviztoprofile3.jpg',
                'description' => 'Fullstack Developer'
            ],
            [
                'name' => 'Farelly Theo Ariela',
                'nim' => 'L0122061',
                'prodi' => 'S1 - Informatika',
                'universitas' => 'Universitas Sebelas Maret',
                'foto' => 'Big Bone Black Boy.jpeg',
                'description' => 'Data Researcher & UI Designer'
            ],
            [
                'name' => 'Ghina Puspamurti',
                'nim' => 'L0122069',
                'prodi' => 'S1 - Informatika',
                'universitas' => 'Universitas Sebelas Maret',
                'foto' => 'jomok1.jpeg',
                'description' => 'Data Researher & Software Tester'
            ],
            [
                'name' => 'Ibrahim Nur Kuda',
                'nim' => 'L0122076',
                'prodi' => 'S1 - Informatika',
                'universitas' => 'Universitas Sebelas Maret',
                'foto' => 'Yamaha NMAX Warna Glossy White.jpeg',
                'description' => 'DevOps Engineer'
            ]
        ];

        return view('developer.index', compact('profiles'));
    }
}