<?php

namespace Utilita\ElectricityBillCalculator\DummyData;

class GenerateDummyData
{
    protected $numOfDataToBeGenerated;
    protected $startDate;
    protected $endDate;

    /**
     * @param $numOfDataToBeGenerated
     * @param $startDate
     * @param $endDate
     */
    public function __construct($numOfDataToBeGenerated, $startDate, $endDate)
    {
        $this->numOfDataToBeGenerated = $numOfDataToBeGenerated;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }


    /**
     * Method to generate dummy json data
     * @param $numOfDataToBeGenerated
     * @param $startDate
     * @param $endDate
     * @return array|false|string
     */
    public function generateDummyJsonData()
    {
        $data = [];
        for ($i = 0; $i < $this->numOfDataToBeGenerated; $i++) {
            $data [] = [
                rand(1, $this->numOfDataToBeGenerated * 10),
                $this->generateRandomDate($this->startDate, $this->endDate),
                rand(1, 200)
            ];
        }
        return json_encode($data);
    }


    /**
     * Method to generate random date between two dates
     * @param $startDate
     * @param $endDate
     * @param string $format
     * @return bool|string
     */
    private function generateRandomDate($startDate, $endDate, string $format = 'Y-m-d\TH:i:s')
    {
        // Convert the supplied date to timestamp
        $fMin = strtotime($startDate);
        $fMax = strtotime($endDate);

        // Generate a random number from the start and end dates
        $fVal = mt_rand($fMin, $fMax);

        // Convert back to the specified date format
        return date($format, $fVal);
    }
}