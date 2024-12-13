<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\EmailTemplate;

class ImportBladeTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:blade-templates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Blade template files into the email_templates database table';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Define the path where your Blade files are stored
        $bladeFiles = [
            'style1' => resource_path('views/email_templates/style1.blade.php'),
            'style2' => resource_path('views/email_templates/style2.blade.php'),
            'style3' => resource_path('views/email_templates/style3.blade.php'),
        ];

        foreach ($bladeFiles as $style => $filePath) {
            if (File::exists($filePath)) {
                // Read the content of the Blade file
                $content = File::get($filePath);

                // Create a new record in the email_templates table
                EmailTemplate::create([
                    'name' => ucfirst($style),  // e.g., 'Style 1'
                    'style' => $style,          // e.g., 'style1'
                    'content' => $content,      // Store the Blade content as is
                    'image_path' => null,       // Optionally store an image path if you have one
                ]);

                $this->info("Template '{$style}' imported successfully!");
            } else {
                $this->error("File '{$filePath}' not found!");
            }
        }
    }
}
