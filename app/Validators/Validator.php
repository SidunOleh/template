<?php

namespace App\Validators;

use App\Validators\Rules\Rule;

class Validator
{
    /** 
     * @var array received values
     */
    private $values = [];

    /** 
     * @var array validation rules
     */
    private $rules = [];

    /** 
     * @var array validated values
     */
    private $validated = [];

    /** 
     * @var array validation errors
     */
    private $errors = [];

    public function __construct(array $rules)
    {
        $this->rules  = $rules;
        $this->values = array_merge($_GET, $_POST, $_FILES);
    }

    /** 
     * Validate received values
     * 
     * @return void
     */
    public function validate()
    {
        foreach ($this->rules as $key => $rule) {
            if (! isset($this->values[$key])) {
                $this->errors[$key] = ucfirst($key) . ' is required';
            } else {
                if (is_string($rule)) {
                    $this->regex($key, $rule);    
                } 
                
                if ($rule instanceof Rule) {
                    $this->rule($key, $rule);
                }
            }
        }
    }

    /** 
     * Validate with regex
     * 
     * @param $key
     * @param string $rule regex
     * @return void
     */
    private function regex($key, $rule)
    {
        preg_match($rule, $this->values[$key]) ? 
            $this->validated[$key] = $this->values[$key] :
            $this->errors[$key] = ucfirst($key) . ' is invalid';
    }

    /** 
     * Validate with Rule
     * 
     * @param $key
     * @param Rule $rule
     * @return void
     */
    private function rule($key, Rule $rule)
    {
        $rule->validate($this->values[$key]) ? 
            $this->validated[$key] = $this->values[$key] :
            $this->errors[$key] = $rule->message();
    }

    /** 
     * Result of validation
     * 
     * @return bool
     */
    public function isFaiulre()
    {
        return $this->errors ? true : false;
    }

    /** 
     * Get validated value
     * 
     * @return array
     */
    public function validated()
    {
        return $this->validated;
    }

    /** 
     * Get validation errors
     * 
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }
}
