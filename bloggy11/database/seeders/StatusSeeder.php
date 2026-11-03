<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collection = [
            [
                'id'    => Status::DRAFT,
                'name'  => 'draft',
            ],[
                'id'    => Status::PUBLISHED,
                'name'  => 'published',
            ],[
                'id'    => Status::HIDDEN,
                'name'  => 'hidden',
            ]
        ];

        foreach ($collection as $item) {
            $model = new Status($item);
            $model->save();
        }
    }
}
