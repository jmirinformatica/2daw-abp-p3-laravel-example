<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class MultilanguageSeeder extends Seeder
{
    public function run(): void
    {
        $collection = [
            [
                'id' => Status::DRAFT,
                'name' => [
                    'ca' => 'Esborrany',
                    'es' => 'Borrador',
                    'en' => 'Draft',
                ],
            ],
            [
                'id' => Status::PUBLISHED,
                'name' => [
                    'ca' => 'Publicat',
                    'es' => 'Publicado',
                    'en' => 'Published',
                ],
            ],
            [
                'id' => Status::HIDDEN,
                'name' => [
                    'ca' => 'Ocult',
                    'es' => 'Oculto',
                    'en' => 'Hidden',
                ],
            ],
        ];

        foreach ($collection as $item) {
            Status::updateOrCreate(
                ['id' => $item['id']],
                ['name' => $item['name']]
            );
        }
    }
}
