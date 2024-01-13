<?php

namespace Utilita\ElectricityBillCalculator;


class CalculateElectricityBill implements PeakOffPeakHoursInterface
{
    /**
     * Method to Calculate Consumption Bill
     * @param $data
     * @param $peak_hour_rate
     * @param $off_peak_hour_rate
     * @return array
     */
    public function calculateBill($data, $peak_hour_rate, $off_peak_hour_rate): array
    {

        $data = json_decode($data);
        $result = [];
        $validation = new Validation();
        try {
            foreach ($data as $values) {
                //$values["0"]
                $meter_id = $validation->isInt($values["0"]);
                $date_time = $validation->isDate($values["1"]);
                $meter_reading = $validation->isIntOrFloat($values["2"]);
                if ($validation->isSuccess()) {
                    if ($this->isPeakHour($date_time)) {
                        $total_bill = round($peak_hour_rate * $meter_reading, 2, 0);
                    } else {
                        $total_bill = round($off_peak_hour_rate * $meter_reading, 2, 0);
                    }

                    $result [] = [
                        "meter_id" => $meter_id,
                        "timestamp" => $date_time,
                        "meter_reading_in_kilowatt_hours" => $meter_reading,
                        "isPeakHourRate" => $this->isPeakHour($date_time) ? "Peak Hour Rate: $peak_hour_rate" : "Off-Peak Hour Rate: $off_peak_hour_rate",
                        "total_bill" => $total_bill
                    ];
                } else {
                    echo $validation->displayErrors();
                }

            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return $result;
    }

    /**
     * Method to check if the hour is peak hour/off-peak hour
     * @param $date_time
     * return bool
     */
    function isPeakHour($date_time): bool
    {
        $posted_hour = date('H:i', strtotime($date_time));
        $posted_hours_minutes = $this->hoursToMinutes($posted_hour);
        $peak_hours_start = $this->hoursToMinutes('07:00');
        $peak_hours_end = $this->hoursToMinutes('23:59');
        if ($posted_hours_minutes >= $peak_hours_start && $posted_hours_minutes <= $peak_hours_end) {
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