<?php

namespace Coop182\LaravelCronValidator;

use Illuminate\Validation\Validator;
use Cron\CronExpression;

class CronValidator extends Validator
{
    private $_custom_messages = array(
        "cron_expression" => "The :attribute is not a vaild cron expression."
    );

    public function __construct($translator, $data, $rules, $messages = array(), $customAttributes = array())
    {
        parent::__construct($translator, $data, $rules, $messages, $customAttributes);

        $this->_set_custom_stuff();
    }

    /**
     * Setup any customizations etc
     *
     * @return void
     */
    protected function _set_custom_stuff()
    {
        //setup our custom error messages
        $this->setCustomMessages($this->_custom_messages);
    }

    /**
     * Allow only valid cron expressions
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    protected function validateCronExpression($attribute, $value)
    {
        try {
            CronExpression::factory($value);
        } catch (\InvalidArgumentException $e) {
            return false;
        }
        return true;
    }
}
