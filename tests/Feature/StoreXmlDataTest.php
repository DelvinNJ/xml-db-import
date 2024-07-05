<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Service\XmlContent;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreXmlDataTest extends TestCase
{
    use RefreshDatabase;

    public $xml_content;
    public function setUp(): void
    {
        parent::setUp();
        $this->xml_content = new XmlContent();
    }

    public function test_FileDoesNotExist()
    {
        $this->artisan('store-xml-data', ['file' => 'file_not_found.txt'])
            ->expectsOutput('File does not exist')
            ->assertExitCode(0);
    }


    public function test_storeValidXmlData()
    {
        $temp_dir = sys_get_temp_dir();
        $temp_file = tempnam($temp_dir, 'xml_') . '.xml';
        file_put_contents($temp_file, $this->xml_content->getValidXmlContent());

        $this->artisan('store-xml-data', ['file' => $temp_file])
            ->expectsOutput('Please be patient; the processing has started.')
            ->expectsOutput('Data validation successfully completed without any errors.')
            ->expectsOutput('Data successfully inserted into the database.')
            ->assertExitCode(0);

        $this->artisan('store-xml-data', ['file' => $temp_file])
            ->expectsOutput('Warning: Validation error occurred')
            ->assertExitCode(0);

        unlink($temp_file);
    }

    public function test_updateValidXmlData()
    {
        $temp_dir = sys_get_temp_dir();
        $temp_file = tempnam($temp_dir, 'xml_') . '.xml';
        file_put_contents($temp_file, $this->xml_content->getValidXmlContent());

        $this->artisan('update-xml-data', ['file' => $temp_file])
            ->expectsOutput('Please be patient; the processing has started.')
            ->expectsOutput('Data updated successfully into the database.')
            ->assertExitCode(0);

        // $temp_file = tempnam($temp_dir, 'repeat_xml_') . '.xml';
        // file_put_contents($temp_file, $this->xml_content->getDuplicateXmlContent());

        // $this->artisan('update-xml-data', ['file' => $temp_file])
        //     ->expectsOutput('Warning: Validation error occurred')
        //     ->assertExitCode(0);

        unlink($temp_file);
    }

    public function test_emptyFile()
    {
        $temp_dir = sys_get_temp_dir();
        $temp_file = tempnam($temp_dir, 'xml_') . '.xml';
        file_put_contents($temp_file, '');

        $this->artisan('store-xml-data', ['file' => $temp_file])
            ->expectsOutput('Error code - [4]: Document is empty')
            ->assertExitCode(0);
            
        $this->artisan('update-xml-data', ['file' => $temp_file])
            ->expectsOutput('Error code - [4]: Document is empty')
            ->assertExitCode(0);
    }
}
