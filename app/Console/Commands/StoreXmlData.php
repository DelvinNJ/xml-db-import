<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Service\FileType;
use App\Service\XmlService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreXmlRequest;
use Illuminate\Support\Facades\Validator;

class StoreXmlData extends Command
{

    protected $signature = 'store-xml-data {file}';
    protected $description = 'Command description';

    public function handle()
    {
        $file_path = $this->argument('file');
        // Check file type
        $file_type_checker = new FileType();
        $file_type = $file_type_checker->checkFileType($file_path);
        if ($file_type != "xml") {
            $this->error($file_type);
            Log::channel('custom')->error($file_type);
            return;
        }

        // Read XML content
        $xml_service = new XmlService($this);
        $data = $xml_service->readXmlFile($file_path);
        if (!$data)
            return;

        $chunks = array_chunk($data, 100);
        $request = new StoreXmlRequest();
        // create progress bar
        $progress_bar = $this->output->createProgressBar(count($chunks));
        $progress_bar->start();

        foreach ($chunks as $chunk) {
            if (!$this->validateChunk($request, $chunk)) {
                $this->line('<fg=yellow>Warning:</> ' . "Validation error occurred");
                $progress_bar->finish();
                $this->newLine();
                return;
            }
            $progress_bar->advance();
        }
        $progress_bar->finish();

        $this->newLine();
        $this->info('Data validation successfully completed without any errors.');

        // Bulk insertion into the database.
        $progress_bar->start();
        foreach ($chunks as $chunk) {
            Product::insert($chunk);
            $progress_bar->advance();
        }
        $progress_bar->finish();
        $this->newLine();
        $this->info('Data successfully inserted into the database.');
        return;
    }

    // Data validation
    private function validateChunk($request, $chunk)
    {
        $validator = Validator::make($chunk, $request->rules());
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Log::channel('custom')->warning($error);
            }
            return false;
        }

        return true;
    }
}
