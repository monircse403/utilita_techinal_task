<?php
declare(strict_types=1);
/*
  * Author: Md Moniruzzzaman
  * Date: 13.01.2024 10:13:00
  * Email: monircse403@gmail.com
  */
require_once __DIR__ . '/vendor/autoload.php';

use Utilita\ElectricityBillCalculator\Controller\CalculateElectricityBill;
use Utilita\ElectricityBillCalculator\DummyData\GenerateDummyData;
use Utilita\ElectricityBillCalculator\Validator\Validation;

// enter argument as 2.3 1.2 or 1.2 3.4
header('Content-Type: application/json; charset=utf-8');

if (isset($argv[1]) && isset($argv[2])) {
    try {
        $validation = new Validation();
        $peakHoursBillingRate = $validation->isNumeric($argv[1]);
        $offPeakHoursBillingRate = $validation->isNumeric($argv[2]);
        if ($validation->isSuccess()) {
            $generateDummyDataObj = new GenerateDummyData(5, '2023-12-01', '2023-12-02');
            $data = $generateDummyDataObj->generateDummyJsonData();
            $calculateElectricityBillObj = new CalculateElectricityBill();
            $billData = $calculateElectricityBillObj->calculateBill($data, $peakHoursBillingRate, $offPeakHoursBillingRate);
            echo json_encode($billData);
        } else {
            echo '<pre>';print_r($validation->getErrors());
        }

    } catch (\Exception $e) {
        echo get_class($e) . ": " . $e->getMessage();
    }
} else {
    echo "No Argument Passed\n";
}


