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
            if ('ulid' === Builder::$defaultMorphKeyType) {
                $table->ulid('id')->primary();
            } elseif ('uuid' === Builder::$defaultMorphKeyType) {
                $table->uuid('id')->primary();
            } else {
                $table->id('id')->primary();
            }

            $table->foreignUlid('language_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignUlid('currency_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->char('code', 2);
            $table->char('iso', 3);
            $table->char('iso_numeric', 3)->nullable();
            $table->string('title', 75);
            $table->string('slug', 75)->nullable();
            $table->char('tax', 2)->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique('code');
            $table->index('status');
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
