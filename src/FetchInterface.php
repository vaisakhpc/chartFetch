<?php
namespace App;

require_once __DIR__ . '/../vendor/autoload.php';

interface FetchInterface
{
    public function fetch() : array;
}
