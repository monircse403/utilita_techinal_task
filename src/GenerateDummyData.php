<?php

namespace Utilita\ElectricityBillCalculator;

class GenerateDummyData
{
    private $num_of_data_to_be_generated;
    private $start_date;
    private $end_date;

    /**
     * @param mixed $num_of_data_to_be_generated
     */
    public function setNumOfDataToBeGenerated($num_of_data_to_be_generated)
    {
        $this->num_of_data_to_be_generated = $num_of_data_to_be_generated;
        return $this;
    }

    /**
     * @param mixed $start_date
     */
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
        return $this;
    }

    /**
     * @param mixed $end_date
     */
    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
        return $this;
    }

    /**
     * Method to generate dummy json data
     * @param $num_of_data_to_be_generated
     * @param $start_date
     * @param $end_date
     * @return string
     */
    public function generateDummyJsonData()
    {
        $data = [];
        for ($i = 0; $i < $this->num_of_data_to_be_generated; $i++) {
            $data [] = [
                rand(1, $this->num_of_data_to_be_generated * 10),
                $this->generateRandomDate($this->start_date, $this->end_date),
                rand(1, 200)
            ];
        }
        return json_encode($data);
    }


    /**
     * Method to generate random date between two dates
     * @param $start_date
     * @param $end_date
     * @param string $format
     * @return bool|string
     */
    private function generateRandomDate($start_date, $end_date, $format = 'Y-m-d\TH:i:s')
    {
        // Convert the supplied date to timestamp
        $fMin = strtotime($start_date);
        $fMax = strtotime($end_date);

        // Generate a random number from the start and end dates
        $fVal = mt_rand($fMin, $fMax);

        // Convert back to the specified date format
        return date($format, $fVal);
    }
}