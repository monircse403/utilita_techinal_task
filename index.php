<?php
/*
  * Author: Md Moniruzzzaman
  * Date: 13.01.2024 10:13:00
  * Email: monircse403@gmail.com
  */
require_once __DIR__ . '/vendor/autoload.php';

use Utilita\ElectricityBillCalculator\Controller\CalculateElectricityBill;
use Utilita\ElectricityBillCalculator\DummyData\GenerateDummyData;

// enter argument as 2.3 1.2 or 1.2 3.4
header('Content-Type: application/json; charset=utf-8');

if (isset($argv[1]) && isset($argv[2])) {
    try {
        $peakHoursBillingRate = $argv[1];
        $offPeakHoursBillingRate = $argv[2];
        if ($peakHoursBillingRate > 0 || $offPeakHoursBillingRate > 0) {
            $generateDummyDataObj = new GenerateDummyData(5, '2023-12-01','2023-12-02');
            $data = $generateDummyDataObj->generateDummyJsonData();
            $calculateElectricityBillObj = new CalculateElectricityBill();
            $billData = $calculateElectricityBillObj
                        ->calculateBill($data, $peakHoursBillingRate, $offPeakHoursBillingRate);
            echo json_encode($billData);
        }

    } catch (\Exception $e) {
        echo $e->getMessage();
    }

}

