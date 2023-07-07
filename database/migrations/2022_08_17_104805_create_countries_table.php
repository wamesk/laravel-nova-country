<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->char('language_code', 5)->nullable()->constrained('languages', 'locale')->cascadeOnUpdate()->nullOnDelete();
            $table->char('currency_code', 3)->nullable()->constrained('currencies', 'code')->cascadeOnUpdate()->nullOnDelete();
            $table->char('continent', 2)->nullable();
            $table->string('world_region', 5)->nullable();
            $table->char('code', 2)->unique();
            $table->string('title', 40);
            $table->unsignedTinyInteger('sort')->default(0)->index();
            $table->boolean('status')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'code']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
