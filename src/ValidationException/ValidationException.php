<?php

namespace Utilita\ElectricityBillCalculator\ValidationException;

class ValidationException extends \Exception
{

    public function invalidBillData() {
        return new static('Bill Data Form Values not Correct');
    }
}