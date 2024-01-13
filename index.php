<?php
/*
  * Author: Md Moniruzzzaman
  * Date: 13.01.2024 10:13:00
  * Email: monircse403@gmail.com
  */
require_once __DIR__ . '/vendor/autoload.php';

use \Utilita\ElectricityBillCalculator\GenerateDummyData;
use \Utilita\ElectricityBillCalculator\CalculateElectricityBill;

if (isset($argv[1]) && isset($argv[2])) {
    try {
        $peak_hours_billing_rate = $argv[1];
        $off_peak_hours_billing_rate = $argv[2];
        if ($peak_hours_billing_rate > 0 || $off_peak_hours_billing_rate > 0) {
            $generateDummyDataObj = new GenerateDummyData();
            $data = $generateDummyDataObj
                ->setNumOfDataToBeGenerated(5)
                ->setStartDate('2023-12-01')
                ->setEndDate('2023-12-02')
                ->generateDummyJsonData();
            $calculateElectricityBillObj = new CalculateElectricityBill();
            $bill_data = $calculateElectricityBillObj->calculateBill($data, $peak_hours_billing_rate, $off_peak_hours_billing_rate);
            echo json_encode($bill_data);
        }

    } catch (\Exception $e) {
        echo $e->getMessage();
    }

}

