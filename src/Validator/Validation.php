<?php

namespace Utilita\ElectricityBillCalculator\Validator;
use Utilita\ElectricityBillCalculator\ValidationException\ValidationException;

/**
 * Class Validation
 * @author Md Moniruzzaman
 * @Email monircse403@gmail.com
 */
class Validation
{


    public $errors = array();

    /**
     * @return boolean
     */
    public function isSuccess()
    {
        if (empty($this->errors)) return true;
    }

    /**
     * @return array $this->errors
     */
    public function getErrors()
    {
        if (!$this->isSuccess()) return $this->errors;
    }


    /**
     * if value is interger
     *
     * @param mixed $value
     * @return mixed
     */
    public function isInt($value)
    {
        if (!$value) {
            return false;
        }
        try {
            if (filter_var($value, FILTER_VALIDATE_INT))
                return $value;
        } catch (ValidationException $e) {
            throw $e->invalidInt();
        }


    }

    /**
     * if value is float
     *
     * @param mixed $value
     * @return
     */
    public function isFloat($value)
    {
        if (!$value) {
            return false;
        }
        try {
            if (filter_var($value, FILTER_VALIDATE_FLOAT)) return $value;
        } catch (ValidationException $e) {
            throw $e->invalidFloat();
        }

    }

    /**
     * if value is int or float
     *
     * @param mixed $value
     * @return mixed
     */

    public function isIntOrFloat($value)
    {
        if (!$value) {
            return false;
        }

        try {
            if ($this->isInt($value) || $this->isFloat($value)) return $value;
        } catch (ValidationException $e) {
            throw $e->invalidIntOrFloat();
        }
    }

    /**
     * Method Check if the value is a valid date
     * @param mixed $value
     * @return string
     * @throws ValidationException
     */
    public function isDate($value) : string
    {
        if (!$value) {
            return false;
        }

        try {
            new \DateTime($value);
            return $value;
        } catch (ValidationException $e) {
            throw $e->invalidDate();
        }
    }


}