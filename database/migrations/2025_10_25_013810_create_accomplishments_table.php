<?php

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
        Schema::create('accomplishments', function (Blueprint $table) {
            $table->id();

            // 🔗 Relation to Projects
            $table->foreignId('project_id')->constrained()->onDelete('cascade');

            $table->string('project_title');
            $table->integer('implementing_year');
            $table->decimal('budget_utilized', 15, 2);
            $table->enum('status', [
                'ongoing',
                'completed',
                'terminated',
                'continuing',
                'graduated',
                'grace_period',
                'liquidated',
                'unliquidated',
            ])->default('ongoing');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accomplishments');
    }
};
