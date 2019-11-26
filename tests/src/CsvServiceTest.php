<?php
namespace Tests\App;

use PHPUnit\Framework\TestCase;
use App\CsvService;

/**
 * Class CsvServiceTest
 */
class CsvServiceTest extends TestCase
{
    private function getInstance()
    {
        return new CsvService(getenv("CSV_PATH"));
    }

    /**
     * Check read to array method
     */
    public function testReadToArray()
    {
        $service = $this->getInstance();
        $response = $service->fetch();
        $this->assertIsArray($response);
    }
}
