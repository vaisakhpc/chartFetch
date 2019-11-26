<?php
namespace App;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Class CsvService
 */
class CsvService implements FetchInterface
{
    /**
     * @var array
     */
    private $elementsArray;

    /**
     * @var string
     */
    private $path;

    /**
     * constructor
     */
    public function __construct(string $path)
    {
        $this->path = $path;
        $this->elementsArray = [];
    }
    /**
     * read CSV contents To An Array
     * @return array
     */
    public function fetch(): array
    {
        $rowNo = 1;
        $result = [];
        if (($fp = @fopen($this->path, "r")) !== false) {
            while (($row = fgetcsv($fp, 1000, ";")) !== false) {
                $num = count($row);
                for ($c = 0; $c < $num; $c++) {
                    if ($rowNo === 1) {
                        $this->elementsArray[] = $row[$c];
                    } else {
                        $result[$rowNo - 2][$this->elementsArray[$c]] = $row[$c];
                    }
                }
                $rowNo++;
            }
            fclose($fp);
        }
        return $result;
    }
}
