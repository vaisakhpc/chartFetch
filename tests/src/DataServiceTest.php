<?php
namespace Tests\App;

use PHPUnit\Framework\TestCase;
use App\DataService;
use App\CsvService;
use Exception;

/**
 * Class DataServiceTest
 */
class DataServiceTest extends TestCase
{
    private function getInstance(string $path)
    {
        return new DataService(new CsvService($path));
    }

    public function testValidateReturnsValidValue()
    {
        $obj = $this->getInstance(getenv("CSV_PATH"));
        $this->assertIsString($obj->fetch());
    }

    public function testValidateThrowsExceptionForInvalidFilePath()
    {
        $obj = $this->getInstance('invalid');
        $this->expectException(Exception::class);
        $obj->fetch();
    }
}
