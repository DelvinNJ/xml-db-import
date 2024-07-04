<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Service\FileType;
use App\Service\XmlService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ImportXmlRequest;
use Illuminate\Support\Facades\Validator;

class StoreXmlData extends Command
{

    protected $signature = 'store-xml-data {file}';
    protected $description = 'Command description';

    public function handle()
    {
        $file_path = $this->argument('file');
        $file_type_checker = new FileType();
        $file_type = $file_type_checker->checkFileType($file_path);
        if ($file_type != "xml") {
            $this->error($file_type);
            return;
        }


        $xml_service = new XmlService($this);
        $data = $xml_service->readXmlFile($file_path);
        if (!$data)
            return;

        $chunks = array_chunk($data, 100);
        $request = new ImportXmlRequest();

        foreach ($chunks as $chunk) {
            if (!$this->validateChunk($request, $chunk)) {
                $this->line('<fg=yellow>Warning:</> ' . "Validation error occurred");
                return;
            }
        }
        $this->info('Data validation successfully completed without any errors.');

        foreach ($chunks as $chunk) {
            Product::insert($chunk);
        }
        $this->info('Data successfully inserted into the database.');

        return;
    }

    private function validateChunk($request, $chunk)
    {
        $validator = Validator::make($chunk, $request->rules());
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Log::warning($error);
            }
            return false;
        }
        return true;
    }
}
