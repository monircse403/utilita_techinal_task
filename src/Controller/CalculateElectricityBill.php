<?php

namespace Utilita\ElectricityBillCalculator\Controller;


use Utilita\ElectricityBillCalculator\UtilitaInterface\PeakOffPeakHoursInterface;
use Utilita\ElectricityBillCalculator\ValidationException\ValidationException;
use Utilita\ElectricityBillCalculator\Validator\Validation;

class CalculateElectricityBill implements PeakOffPeakHoursInterface
{
    /**
     * Method to Calculate Consumption Bill
     * @param $data
     * @param $peakHourRate
     * @param $offPeakHourRate
     * @return array
     */
    public function calculateBill($data, $peakHourRate, $offPeakHourRate): array
    {

        $data = json_decode($data);
        $result = [];
        $validation = new Validation();
        try {
            foreach ($data as $values) {
                //$values["0"]
                $meterId = $validation->isInt($values["0"]);
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
                }

            }
        } catch (ValidationException $e) {
            echo $e->invalidBillData();
        }

        return $result;
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
        $peakHoursStart = $this->hoursToMinutes('07:00');
        $peakHoursEnd = $this->hoursToMinutes('23:59');
        if ($postedHoursToMinutes >= $peakHoursStart && $postedHoursToMinutes <= $peakHoursEnd) {
            return true;
        } else {
            return false;
        }
    }

    private function hoursToMinutes($hours): int
    {
        $minutes = 0;
        if (strpos($hours, ':') !== false)
        {
            // Split hours and minutes.
            list($hours, $minutes) = explode(':', $hours);
        }
        return $hours * 60 + $minutes;
    }

}