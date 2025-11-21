<?php

namespace Database\Seeders;

use App\Models\Todolist;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TodolistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Todolist::insert([
           [
            'title' => 'Belajar coding',
            'desc' => 'belajar selama 20 jam sehari ya',
            'is_done' => true
           ],
           [
            'title' => 'Olahraga',
            'desc' => 'kurang lebih selama 20 menit ya',
            'is_done' => false
           ]
        ]);
    }
}
