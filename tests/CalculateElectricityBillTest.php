<?php

namespace Utilita\ElectricityBillCalculator\tests;

use PHPUnit\Framework\TestCase;
use Utilita\ElectricityBillCalculator\GenerateDummyData;

class CalculateElectricityBillTest extends TestCase
{

    /** @tests */
    public function genereateDummpyDataTest(){
        $generateDummyDataObj = new GenerateDummyData();
        $data = $generateDummyDataObj->setNumOfDataToBeGenerated(5)
            ->setStartDate('2023-12-01')
            ->setEndDate('2023-12-02')
            ->generateDummyJsonData();

    }
}