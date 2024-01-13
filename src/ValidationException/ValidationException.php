<?php

namespace Utilita\ElectricityBillCalculator\ValidationException;

class ValidationException extends \Exception
{

    public  function invalidInt() {
        return new static('Parameter Must be integer');
    }

    public  function invalidFloat() {
        return new static('Parameter Must be float');
    }

    public  function invalidIntOrFloat() {
        return new static('Parameter Must be Integer or Float');
    }

    public  function invalidDate() {
        return new static('Date Format is not Correct');
    }

    public  function invalidBillData() {
        return new static('Bill Data Form Values not Correct');
    }
}