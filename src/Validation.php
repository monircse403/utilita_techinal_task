<?php

namespace Utilita\ElectricityBillCalculator;
/**
 * Class Validation
 * @author Md Moniruzzaman
 * @Email monircse403@gmail.com
 */
class Validation
{

    /**
     * @var array $errors
     */
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
     * error in Html format
     *
     * @return string $html
     */
    public function displayErrors()
    {

        $html = '<ul>';
        foreach ($this->getErrors() as $error) {
            $html .= '<li>' . $error . '</li>';
        }
        $html .= '</ul>';

        return $html;

    }

    /**
     * if value is interger
     *
     * @param mixed $value
     * @return boolean
     */
    public function isInt($value)
    {
        if (filter_var($value, FILTER_VALIDATE_INT)) return $value; else $this->errors[] = 'not valid';
    }

    /**
     * if value is float
     *
     * @param mixed $value
     * @return
     */
    public function isFloat($value)
    {
        if (filter_var($value, FILTER_VALIDATE_FLOAT)) return $value; else $this->errors[] = 'not valid';
    }

    /**
     * if value is int or float
     *
     * @param mixed $value
     * @return mixed
     */

    public function isIntOrFloat($value)
    {
        if ($this->isInt($value) || $this->isFloat($value)) return $value; else $this->errors[] = 'not valid';
    }

    /**
     * Method Check if the value is a valid date
     * @param mixed $value
     * @return boolean
     */
    public function isDate($value)
    {
        if (!$value) {
            return false;
        }

        try {
            new \DateTime($value);
            return $value;
        } catch (\Exception $e) {
            $this->errors[] = 'not valid date';
            return false;
        }
    }


}