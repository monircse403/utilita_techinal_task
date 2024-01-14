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
     * @throws ValidationException
     */
    public function calculateBill($data, $peakHourRate, $offPeakHourRate): array
    {

        $data = json_decode($data);
        $result = [];
        $data = $this->skipInValidDataFromArray($data);
        try {
            foreach ($data as $values) {
                $meterId = $values["0"];
                $dateTime = $values["1"];
                $meter_reading = $values["2"];
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
        } catch (ValidationException $e) {
            echo $e->invalidBillData();
        }

        return $result;
    }

    /**
     * @throws ValidationException
     */
    private function skipInValidDataFromArray($data): array
    {
        $finalData = [];
        $validation = new Validation();
        foreach ($data as $values) {
            if($validation->isIntOrFloat($values["0"]) && $validation->isDate($values["1"]) && $validation->isIntOrFloat($values["2"])){
                $finalData[]  = $values;
            }
        }
        return $finalData;
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

    /**
     * Method to covert hours into minutes
     * @param $hours
     * @return int
     */
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