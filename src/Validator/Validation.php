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

    private $errors = array();

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
     * @return  mixed
     * @throws ValidationException
     */
    public function isInt($value)
    {
        if (!$value) {
            $this->errors [] = 'Input Cannot Be Null or Empty';
        }
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            $this->errors [] = 'Input Must Be Integer';

        }
        return true;


    }

    /**
     * if value is float
     *
     * @param mixed $value
     * @throws ValidationException
     */
    public function isFloat($value)
    {
        if (!$value) {
            $this->errors [] = 'Input Cannot Be Null or Empty';
        }
        if (!filter_var($value, FILTER_VALIDATE_FLOAT)) {
            $this->errors [] = 'Input Must Be Float';
        }
        return true;


    }

    /**
     * if value is int or float
     *
     * @param mixed $value
     * @return mixed
     * @throws ValidationException
     */

    public function isIntOrFloat($value)
    {
        if (!$value) {
            $this->errors [] = 'Input Cannot Be Null or Empty';
        }
        try {
            if (!$this->isInt($value) || !$this->isFloat($value)) {
                $this->errors [] = 'Input Must Be Integer or Float';
            }
            return $value;
        } catch (ValidationException $e) {
            $this->errors [] = get_class($e) . ": " . $e->invalidIntOrFloat();
        }
    }

    /**
     * Method Check if the value is a valid date
     * @param mixed $value
     * @return string
     * @throws ValidationException
     */
    public function isDate($value)
    {
        if (!$value) {
            $this->errors [] = 'Input Cannot Be Null or Empty';
            return false;
        }
        try {
            if (new \DateTime($value)) return $value; else return false;
        } catch (ValidationException $e) {
            $this->errors [] = get_class($e) . ": " . $e->invalidDate();
        }
    }

    public function isNumeric($value)
    {
        try {
            if (!$value) {
                $this->errors [] = 'Number Must be Greater then Zero';
            }

            if (!is_numeric($value)) {
                $this->errors [] = 'Number Must be Integer or Float';
            }
            return $value;
        } catch (\Exception $e) {
            $this->errors [] = get_class($e) . ": " . $e->getMessage();;
        }
    }

}