<?php

namespace Utilita\ElectricityBillCalculator;

interface PeakOffPeakHoursInterface
{
    function isPeakHour($date_time);
}