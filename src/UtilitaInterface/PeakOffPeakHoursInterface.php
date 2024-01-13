<?php

namespace Utilita\ElectricityBillCalculator\UtilitaInterface;

interface PeakOffPeakHoursInterface
{
    function isPeakHour($dateTime);
}