<?php

namespace App\Console\Commands;

use App\Models\Parking;
use Illuminate\Console\Command;

class GenerateSlugs extends Command
{
    protected $signature = 'generate:slugs';

    protected $description = 'Generate slugs for all records without slugs';

    public function handle()
    {
        $parkings = Parking::all();


        foreach ($parkings as $parking) {
            $parking->slug = $parking->generateSlug();
            $parking->save();
            $this->info('Generated slug for post ID ' . $parking->id);
        }

        $this->info('All slugs have been generated successfully!');
    }
}
