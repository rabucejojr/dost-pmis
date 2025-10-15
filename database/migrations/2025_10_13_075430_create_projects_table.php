<?php

use App\Enums\ProjectStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('projects', function (Blueprint $table) {
        $table->id();

        // Foreign key to programs table
        $table->foreignId('program_id')->constrained()->onDelete('cascade');

        $table->string('title');
        $table->text('description')->nullable();
        $table->string('location')->nullable();

        // Enum for project status
        $table->enum('status', ['ongoing','completed','terminated','continuing','graduated','grace_period','liquidated','unliquidated'])->default('ongoing');

        $table->decimal('budget', 15, 2)->default(0);
        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();

        $table->string('project_leader');
        $table->string('contact_email')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
