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
     * @return  boolean
     */
    public function isInt($value)
    {
        if (filter_var($value, FILTER_VALIDATE_INT)) return true;
    }

    /**
     * if value is float
     *
     * @param mixed $value
     * @return  boolean
     */
    public function isFloat($value)
    {
        if (filter_var($value, FILTER_VALIDATE_FLOAT)) return true;
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
        try {
            if (!$value && !$this->isInt($value) || !$this->isFloat($value)) {
                $this->errors [] = 'Input Must Be Integer or Float: ' . $value;
            }
            return $value;
        } catch (\Exception $e) {
            $this->errors [] = get_class($e) . ": " . $e->getMessage();
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
            $this->errors [] = 'Input Cannot Be Null or Empty: ' . $value;
            return false;
        }
        try {
            if (new \DateTime($value)) return $value; else return false;
        } catch (\Exception $e) {
            $this->errors [] = get_class($e) . ": " . $e->getMessage();
        }
    }

    public function isNumeric($value)
    {
        try {
            if (!$value || !is_numeric($value)) {
                $this->errors [] = 'Number Must be Greater then Zero and Must be Integer or Float: ' . $value;
            }

            return $value;
        } catch (\Exception $e) {
            $this->errors [] = get_class($e) . ": " . $e->getMessage();;
        }
    }

}