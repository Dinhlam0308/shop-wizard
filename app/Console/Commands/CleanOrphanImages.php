<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Cloudinary\Api\Admin\AdminApi;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\Product;
use App\Models\ProductImage;

class CleanOrphanImages extends Command
{
    protected $signature = 'cloudinary:clean-orphans';
    protected $description = 'Delete orphan images from Cloudinary not linked in DB';

    public function handle()
    {
        $this->info("Fetching images in DB...");

        // Collect all public_ids in DB
        $dbPublicIds = collect()
            ->merge(Product::pluck('public_id')->toArray())
            ->merge(ProductImage::pluck('public_id')->toArray())
            ->filter()
            ->unique()
            ->values();

        $this->info("Found " . $dbPublicIds->count() . " images in DB.");

        // Get all images from Cloudinary (paginate if too many)
        $adminApi = new AdminApi();
        $cloudImages = $adminApi->assets(["type" => "upload", "prefix" => "products"]);

        $orphans = [];
        foreach ($cloudImages['resources'] as $image) {
            if (!$dbPublicIds->contains($image['public_id'])) {
                $orphans[] = $image['public_id'];
            }
        }

        if (empty($orphans)) {
            $this->info("No orphan images found.");
            return;
        }

        $this->warn("Deleting " . count($orphans) . " orphan images...");
        foreach ($orphans as $publicId) {
            Cloudinary::destroy($publicId);
        }

        $this->info("Done! All orphan images cleaned up.");
    }
}
