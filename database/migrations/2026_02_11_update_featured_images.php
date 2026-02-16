<?php

use App\Models\InspirationPost;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing posts with featured_image based on slug
        $mappings = [
            'biet-thu-hien-dai-voi-gach-royal' => 'biet-thu-hien-dai-voi-gach-royal.png',
            'phong-tam-sang-trong-voi-thiet-bi-toto' => 'phong-tam-sang-trong-voi-thiet-bi-toto.png',
        ];

        foreach ($mappings as $slug => $image) {
            InspirationPost::where('slug', $slug)
                ->whereNull('featured_image')
                ->update(['featured_image' => $image]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to revert
    }
};
