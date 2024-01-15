<?php
declare(strict_types=1);
/*
  * Author: Md Moniruzzzaman
  * Date: 15.01.2024 10:13:00
  * Email: monircse403@gmail.com
  */
require_once __DIR__ . '/vendor/autoload.php';

use Utilita\ElectricityBillCalculator\Controller\CalculateElectricityBillController;
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
            // 5 => num of rows to generate for array
            // 2023-12-01 => start date from when the data is started
            // 2023-12-02' => end date from when the data is ended
            $generateDummyDataObj = new GenerateDummyData(5, '2023-12-01', '2023-12-02');
            $dummyData = $generateDummyDataObj->generateDummyJsonData();
            $calculateElectricityBillObj = new CalculateElectricityBillController();
            $billData = $calculateElectricityBillObj->calculateBill($dummyData, $peakHoursBillingRate, $offPeakHoursBillingRate);
            if (is_array($billData)) echo json_encode($billData);
        } else {
            echo '<pre>';
            print_r($validation->getErrors());
        }

    } catch (\Exception $e) {
        echo get_class($e) . ": " . $e->getMessage();
    }
} else {
    echo "No Argument Passed\n";
}


