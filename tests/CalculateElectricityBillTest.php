<?php

namespace Utilita\ElectricityBillCalculator\tests;

use PHPUnit\Framework\TestCase;
use Utilita\ElectricityBillCalculator\DummyData\GenerateDummyData;

class CalculateElectricityBillTest extends TestCase
{

    /** @tests */
    public function genereateDummpyDataTest(){
        $generateDummyDataObj = new GenerateDummyData(5, '2023-12-01', '2023-12-02');
        $data = $generateDummyDataObj->generateDummyJsonData();

    }
}