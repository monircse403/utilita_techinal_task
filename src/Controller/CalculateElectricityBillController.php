<?php

namespace Utilita\ElectricityBillCalculator\Controller;


use Utilita\ElectricityBillCalculator\Config\Config;
use Utilita\ElectricityBillCalculator\UtilitaInterface\PeakOffPeakHoursInterface;
use Utilita\ElectricityBillCalculator\ValidationException\ValidationException;
use Utilita\ElectricityBillCalculator\Validator\Validation;

class CalculateElectricityBillController implements PeakOffPeakHoursInterface
{
    /**
     * Method to Calculate Consumption Bill
     * @param $data
     * @param $peakHourRate
     * @param $offPeakHourRate
     * @return array
     */
    public function calculateBill($data, $peakHourRate, $offPeakHourRate)
    {

        $data = json_decode($data);
        $result = [];
        $validation = new Validation();
        $error = NULL;
        try {
            foreach ($data as $values) {
                $meterId = $validation->isIntOrFloat($values["0"]);
                $dateTime = $validation->isDate($values["1"]);
                $meter_reading = $validation->isIntOrFloat($values["2"]);
                if ($validation->isSuccess()) {
                    if ($this->isPeakHour($dateTime)) {
                        $totalBill = round($peakHourRate * $meter_reading, 2, 0);
                    } else {
                        $totalBill = round($offPeakHourRate * $meter_reading, 2, 0);
                    }
                    $result [] = [
                        "meterId" => $meterId,
                        "timestamp" => $dateTime,
                        "meter_reading_in_kilowatt_hours" => $meter_reading,
                        "isPeakHourRate" => $this->isPeakHour($dateTime) ? "Peak Hour Rate: $peakHourRate" : "Off-Peak Hour Rate: $offPeakHourRate",
                        "totalBill" => $totalBill
                    ];
                } else {
                    $error = $validation->getErrors();
                }
            }
        } catch (ValidationException $e) {
            $error = $e->invalidBillData();
        }
        if (empty($error)) {
            return $result;
        } else {
            echo '<pre>';
            print_r($error);
            return false;
        }

    }

    /**
     * Method to check if the hour is peak hour/off-peak hour
     * @param $dateTime
     * return bool
     */
    function isPeakHour($dateTime): bool
    {
        $postedHour = date('H:i', strtotime($dateTime));
        $postedHoursToMinutes = $this->hoursToMinutes($postedHour);
        $peakHoursStart = $this->hoursToMinutes(Config::PEAK_HOUR_START);
        $peakHoursEnd = $this->hoursToMinutes(Config::PEAK_HOUR_END);
        if ($postedHoursToMinutes >= $peakHoursStart && $postedHoursToMinutes <= $peakHoursEnd) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method to covert hours into minutes
     * @param $hours
     * @return int
     */
    private function hoursToMinutes($hours): int
    {
        $minutes = 0;
        if (strpos($hours, ':') !== false) {
            // Split hours and minutes.
            list($hours, $minutes) = explode(':', $hours);
        }
        return $hours * 60 + $minutes;
    }

}