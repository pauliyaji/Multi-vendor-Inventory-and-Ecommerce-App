<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Approval;

class CreateApprovalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Approval::create([
            'name' => 'Approved',
        ]);
        Approval::create([
            'name' => 'Not Approved',
        ]);
    }
}
