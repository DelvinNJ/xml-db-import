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
        foreach ($data as $value) {
            $request = new UpdateXmlRequest($value['entity_id']);
            if (!$this->validateChunk($request, $value)) {
                $this->line('<fg=yellow>Warning:</> ' . "Validation error occurred");
                return;
            }
            Product::updateOrCreate(['sku' => $value['sku']], $value);
        }

        $this->info('Data validation successfully completed without any errors.');
        $this->info('Data updated successfully into the database.');
    }


    private function validateChunk($request, $value)
    {
        $validator = Validator::make($value, $request->rules());
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Log::warning('Entity ID:' . $value['entity_id'] . ' - ' . '' . $error);
            }
            return false;
        }
        return true;
    }
}
