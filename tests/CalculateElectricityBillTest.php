<?php

namespace Utilita\ElectricityBillCalculator;

use PHPUnit\Framework\TestCase;
use Utilita\ElectricityBillCalculator\Controller\CalculateElectricityBillController;

class CalculateElectricityBillTest extends TestCase
{

    /** @tests
     */
    public function testCalculateBill(){

        $data[] = [
            "0" => 1,
            "1" => "2023-12-01T14:38:04",
            "2" => 50
        ];
        $data = json_encode($data);
        $peakHoursBillingRate = 4.00;
        $offPeakHoursBillingRate = 2.00;
        $calculateElectricityBillObj = new CalculateElectricityBillController();
        $actual = $calculateElectricityBillObj->calculateBill($data, $peakHoursBillingRate, $offPeakHoursBillingRate);
        $expected [] = [
            "meterId" => 1,
            "timestamp" => "2023-12-01T14:38:04",
            "meter_reading_in_kilowatt_hours" => 50,
            "isPeakHourRate" => "Peak Hour Rate: 4",
            "totalBill" => 200.0
        ];
        $this->assertSame($expected, $actual, "Both Result is Not same");

    }
}