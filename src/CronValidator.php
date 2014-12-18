<?php

namespace Coop182\LaravelCronValidator;

use Illuminate\Validation\Validator;

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
     * Build Cron Regex
     *
     * Taken from http://stackoverflow.com/questions/235504/validating-crontab-entries-w-php
     *
     * @author Jordi Salvat i Alabart - with thanks to <a href="www.salir.com">Salir.com</a>.
     */
    function buildRegexp()
    {
        $numbers = array(
            'min' => '[0-5]?\d',
            'hour' => '[01]?\d|2[0-3]',
            'day' => '0?[1-9]|[12]\d|3[01]',
            'month' => '[1-9]|1[012]',
            'dow' => '[0-6]'
        );

        foreach ($numbers as $field => $number) {
            $range = "(?:$number)(?:-(?:$number)(?:\/\d+)?)?";
            $field_re[$field] = "\*(?:\/\d+)?|$range(?:,$range)*";
        }

        $field_re['month'].='|jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec';
        $field_re['dow'].='|mon|tue|wed|thu|fri|sat|sun';

        $fields_re = '(' . join(')\s+(', $field_re) . ')';

        $replacements = '@reboot|@yearly|@annually|@monthly|@weekly|@daily|@midnight|@hourly';

        return '^\s*(' .
                '$' .
                '|#' .
                '|\w+\s*=' .
                "|$fields_re\s+" .
                "|($replacements)\s+" .
                ')' .
                '([^\\s]+)\\s+' .
                '(.*)$';
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
        return (bool) preg_match("/" . $this->buildRegexp() . "/", $value);
    }
}
