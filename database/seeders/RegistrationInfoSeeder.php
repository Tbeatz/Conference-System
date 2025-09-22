<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RegistrationInfo;

class RegistrationInfoSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['label' => 'Foreign Participants', 'value' => '200 USD', 'type' => 'fee'],
            ['label' => 'Local Participants', 'value' => '200,000 MMK', 'type' => 'fee'],
            ['label' => 'Submission Email', 'value' => 'studentaffairs@ucspyay.edu.mm', 'type' => 'email'],
            ['label' => 'KPay QR', 'value' => 'qr_images/kpay.jpg', 'type' => 'qr_image'],
        ];

        foreach ($data as $item) {
            RegistrationInfo::create($item);
        }
    }
}
