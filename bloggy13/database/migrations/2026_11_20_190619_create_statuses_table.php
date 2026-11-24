<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Status;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
        });

        // Call seeder
        Artisan::call('db:seed', [
            '--class' => 'StatusSeeder',
            '--force' => true
        ]);

        // Update posts table
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')
                ->default(Status::PUBLISHED)
                ->after('author_id'); // MariaDB / MySQL
            $table->foreign('status_id')
                ->references('id')->on('statuses')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });

        // Update old posts with default status
        DB::update(
            "UPDATE posts
             SET status_id = " . Status::PUBLISHED . "
             WHERE status_id IS NULL",
        );           
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
