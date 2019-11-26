<?php
namespace App;

use Exception;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Class DataService
 */
class DataService
{
    private $fetchService;

    const ALLOWED_VALUES = [0, 20, 40, 50, 70, 90, 99, 100];

    public function __construct(FetchInterface $fetchService)
    {
        $this->fetchService = $fetchService;
    }

    public function fetch(): string
    {
        $response = $this->fetchService->fetch();
        $response = $this->processData($response);
        if (empty($response)) {
            throw new Exception("Result is empty");
        } else {
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
    }

    public function processData(array $response): array
    {
        $result = $json = [];
        if (!empty($response)) {
            $weekStart = $response[0]['created_at'];
            $weekEnd = date('Y-m-d', strtotime($weekStart . "+7 days"));
            $i = 1;
            foreach ($response as $key => $value) {
                if (strtotime($value['created_at']) < strtotime($weekEnd)) {
                } else {
                    $i++;
                    $weekStart = $weekEnd;
                    $weekEnd = date('Y-m-d', strtotime($weekStart . "+7 days"));
                }
                $percentage = $this->floorToNearValue($value['onboarding_perentage']);
                if (isset($result[$i][$percentage])) {
                    $result[$i][$percentage]++;
                } else {
                    $result[$i][$percentage] = 1;
                }
            }

            foreach ($result as $key => $value) {
                foreach (self::ALLOWED_VALUES as $allowed) {
                    if (!isset($result[$key][$allowed])) {
                        $result[$key][$allowed] = 0;
                    }
                }
                ksort($result[$key], SORT_NUMERIC);
                $json[] = [
                    'name' => 'Week ' . $key,
                    'data' => $this->getPercent($result[$key]),
                ];
            }
        }
        return $json;
    }

    private function getPercent(array $result): array
    {
        $sum = array_sum($result);
        $response = [];
        foreach ($result as $val) {
            $response[] = round(($val/$sum) * 100);
        }
        $response[0] = 100;
        return $response;
    }

    private function floorToNearValue(string $value): string
    {
        foreach (array_reverse(self::ALLOWED_VALUES) as $allowed) {
            if ($value >= $allowed) {
                return $allowed;
            }
        }
    }
}

$obj = new DataService(new CsvService(__DIR__ . DIRECTORY_SEPARATOR . '../data/export.csv')); // can replace with MySQL classes which implements App/FetchInterface
echo $obj->fetch();
