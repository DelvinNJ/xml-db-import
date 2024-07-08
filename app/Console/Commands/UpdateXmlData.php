<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Service\FileType;
use App\Service\XmlService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\UpdateXmlRequest;
use Illuminate\Support\Facades\Validator;

class UpdateXmlData extends Command
{
    protected $signature = 'update-xml-data {file}';
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
        $data = $xml_service->readXmlFile($file_path, false);
        if (!$data)
            return;

        // create progress bar
        $progress_bar = $this->output->createProgressBar(count($data));
        $progress_bar->start();

        foreach ($data as $value) {
            $request = new UpdateXmlRequest($value['entity_id']);
            if (!$this->validateChunk($request, $value)) {
                $this->newLine();
                $this->line('<fg=yellow>Warning:</> ' . "Validation error occurred");
                $progress_bar->finish();
                return;
            }
            Product::updateOrCreate(['sku' => $value['sku']], $value);
            $progress_bar->advance();
        }
        $this->newLine();
        $progress_bar->finish();
        $this->info('Data updated successfully into the database.');
    }

    // Data validation
    private function validateChunk($request, $value)
    {
        $validator = Validator::make($value, $request->rules());
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Log::channel('custom')->warning(
                    'Entity ID:' . $value['entity_id'] . ' - ' . '' . $error
                );
            }
            return false;
        }

        return true;
    }
}
