<?php

namespace Tests\Unit;

use App\Service\FileType;
use PHPUnit\Framework\TestCase;

class FileTypeTest extends TestCase
{
    protected $fileType;

    protected function setUp(): void
    {
        parent::setUp();
        $this->fileType = new FileType();
    }

    public function testFileDoesNotExist()
    {
        $result = $this->fileType->checkFileType('file_not_found.txt');
        $this->assertEquals('File does not exist', $result);
    }

    public function testFileHasNoExtension()
    {
        $testDir = sys_get_temp_dir() . '\no_ext';
        if (!is_dir($testDir)) {
            mkdir($testDir);
        }

        $file = $testDir . '\no_ext';
        file_put_contents($file, 'Test content');

        $result = $this->fileType->checkFileType($file);
        $this->assertEquals('unknown', $result);

        unlink($file);
        rmdir($testDir);
    }

    public function testFileIsXml()
    {
        $temp_dir = sys_get_temp_dir();
        $temp_file = tempnam($temp_dir, 'xml_') . '.xml';
        file_put_contents($temp_file, '<root></root>');
        $result = $this->fileType->checkFileType($temp_file);
        $this->assertEquals('xml', $result);
        unlink($temp_file);
    }

    public function testFileIsJson()
    {
        $temp_dir = sys_get_temp_dir();
        $temp_file = tempnam($temp_dir, 'json_') . '.json';
        file_put_contents($temp_file, '{"key": "value"}');
        $result = $this->fileType->checkFileType($temp_file);
        $this->assertEquals('json', $result);
        unlink($temp_file);
    }

    public function testFileIsUnprocessable()
    {
        $temp_dir = sys_get_temp_dir();
        $temp_file = tempnam($temp_dir, 'txt_') . '.txt';
        file_put_contents($temp_file, 'Dummy content');
        $result = $this->fileType->checkFileType($temp_file);
        $this->assertEquals('Unprocessable file type', $result);
        unlink($temp_file);
    }
}
