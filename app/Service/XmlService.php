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

    public function readXmlFile($file_path, $mode = true)
    {
        libxml_use_internal_errors(true);
        $xml_content = simplexml_load_file($file_path);
        if ($xml_content === false) {
            $this->handleXmlErrors();
            return false;
        }

        $this->command->info('Please be patient; the processing has started.');
        try {
            return $this->parseXMLContent($xml_content, $mode);
        } catch (\Throwable $th) {
            $message = 'Error occurred: ' . $th->getMessage();
            $this->command->error($message);
            Log::channel('custom')->error($message);
            return false;
        }
    }

    private function handleXmlErrors()
    {
        $errors = libxml_get_errors();
        foreach ($errors as $error) {
            $message = sprintf(
                'Error code - [%d]: %s',
                $error->code,
                trim($error->message)
            );
            Log::channel('custom')->error($message);
            $this->command->error($message);
        }

        libxml_clear_errors();
        return;
    }

    // Parse XML content
    private function parseXMLContent($xml_content, $mode)
    {
        $data = [];
        $entity_ids = [];
        $skus = [];
        foreach ($xml_content as $value) {
            $entity_id = (string) $value->entity_id;
            $sku = (string) $value->sku;
            if ($mode && (in_array($entity_id, $entity_ids) || in_array($sku, $skus))) {
                $message = "Duplicated entries found: entity_id - " . $entity_id;
                $this->command->error($message);
                Log::channel('custom')->error($message);
                return false;
            }

            $data[] = [
                'entity_id' => $entity_id,
                'category_name' => $value->CategoryName,
                'sku' => $sku,
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
            $entity_ids[] = $entity_id;
            $skus[] = $sku;
        }
        return $data;
    }
}
