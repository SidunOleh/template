<?php

namespace App\Validators\Rules;

interface Rule
{
    /** 
     * Validate value
     * 
     * @param $value
     * @return bool result of validation
     */
    function validate($value) : bool;

    /** 
     * Get error message
     * 
     * @return string error message
     */
    function message() : string;
}
