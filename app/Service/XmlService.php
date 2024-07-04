<?php

namespace App\Service;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class XmlService
{

    protected $command;

    public function __construct(Command $command)
    {
        $this->command = $command;
    }
    public function readXmlFile($file_path)
    {
        libxml_use_internal_errors(true);
        $xml_content = simplexml_load_file($file_path);
        if ($xml_content === false) {
            $this->handleXmlErrors();
            return false;
        }
        $this->command->info('Please be patient; the processing has started.');
        try {
            return $this->parseXMLContent($xml_content);
        } catch (\Throwable $th) {
            $message = 'Error occurred: ' . $th->getMessage();
            $this->command->error($message);
            Log::error($message);
            return false;
        }
    }
    private function handleXmlErrors()
    {
        $errors = libxml_get_errors();
        foreach ($errors as $error) {
            $message = sprintf(
                'Error code - [%d]: %s in %s (Line: %d, Column: %d)',
                $error->code,
                trim($error->message),
                $error->file ?: 'Unknown file',
                $error->line,
                $error->column
            );
            Log::error($message);
            $this->command->error($message);
        }
        libxml_clear_errors();
        return;
    }
    private function parseXMLContent($xml_content)
    {
        $data = [];
        foreach ($xml_content as $value) {
            $data[] = [
                'entity_id' => $value->entity_id,
                'category_name' => $value->CategoryName,
                'sku' => $value->sku,
                'name' => $value->name,
                'description' => $value->description,
                'short_desc' => $value->shortdesc,
                'price' => floatval($value->price),
                'link' => trim($value->link),
                'image' => trim($value->image),
                'brand' => $value->Brand,
                'rating' => $value->Rating != '' ? $value->Rating : null,
                'caffeine_type' => $value->CaffeineType,
                'count' => $value->Count != '' ? $value->Count : null,
                'flavored' => strtolower($value->Flavored) == 'yes' ? true : false,
                'seasonal' => strtolower($value->Seasonal) == 'yes' ? true : false,
                'in_stock' => strtolower($value->Instock) == 'yes' ? true : false,
                'facebook' => $value->Facebook == 1 ? true : false,
                'is_kcup' => $value->IsKCup == 1 ? true : false,
            ];
        }
        return $data;
    }
}
