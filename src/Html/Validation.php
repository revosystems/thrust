<?php

namespace BadChoice\Thrust\Html;

class Validation
{
    protected $rules;
    protected $type;

    public function __construct(null|string|array $rules, $type = 'text')
    {
        $this->rules    = collect(is_string($rules)
            ? explode('|', $rules)
            : $rules
        );
        $this->type     = $type;
    }

    public static function make($rules, $type = 'text')
    {
        return new self($rules, $type);
    }

    public function generate()
    {
        return $this->rules->flatMap(function ($rule) {
            return $this->appendRule($rule);
        });
    }

    public function appendRule($rule) : array
    {
        $params = collect(explode(':', $rule));
        $rule   = $params->first();
        if ($rule == 'required') {
            return $this->ruleRequired();
        } elseif ($rule == 'min') {
            return $this->ruleMin($params[1]);
        } elseif ($rule == 'max') {
            return $this->ruleMax($params[1]);
        } elseif ($rule == 'digits') {
            return $this->ruleDigits($params[1]);
        } elseif ($rule == 'email') {
            return $this->ruleEmail();
        } elseif ($rule == 'ip') {
            return $this->ruleIp();
        } elseif ($rule == 'regex') {
            return $this->ruleRegex($params[1]);
        }
        return [];
    }

    public function ruleRequired() : array
    {
        return ['required' => 'true'];
    }

    public function ruleMin($min) : array
    {
        if ($this->type == 'number') {
            return $this->ruleNumberMin($min);
        }
        return [
            'pattern' => ".{{$min},}",
            'title' => "Min $min or more characters"
        ];
    }

    public function ruleMax($max) : array
    {
        if ($this->type == 'number') {
            return $this->ruleNumberMax($max);
        }
        return [
            'pattern' => ".{0,$max}",
            'title' => "Max $max characters"
        ];
    }

    public function ruleDigits($digits) : array
    {
        return [
            "pattern" => ".{".$digits.','.$digits."}",
            "title" => "Digits ".$digits." characters"
        ];
    }

    public function ruleEmail() : array
    {
        if ($this->type == 'email') {
            return [];
        }
        return [
            "pattern" => '/^[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,4}$/'
        ];
    }

    public function ruleIp() : array
    {
        return ["pattern" => '((^|\\.)((25[0-5])|(2[0-4]\\d)|(1\\d\\d)|([1-9]?\\d))){4}$'];
    }

    public function ruleNumberMin($min) : array
    {
        return ["min" => $min];
    }

    public function ruleNumberMax($max) : array
    {
        return ["max" => $max];
    }

    public function ruleRegex($regex) : array
    {
        $pattern = str_replace('/', '', $regex);
        return [
            "pattern" => '{$pattern}',
            "title" => '{$pattern}'
        ];
    }
}

/*

function validateForm(rules){
    jQuery.each(rules, function(key, val) {
        var rules = val.split("|");
        jQuery.each(rules, function(i, rule){
            addRule(key,rule);
        });
    });
}

function addRule(field, rule){
    var params = rule.split(":");
    rule = params[0];
    //console.log("Add rule " + rule + " to field " + field);
    if      (rule == 'required') addRuleRequired(field);
    else if (rule == 'email')    addRuleEmail   (field);
    else if (rule == 'numeric')  addRuleNumeric (field);
    else if (rule == 'numeric')  addRuleInteger (field);
    else if (rule == 'min')      addRuleMin     (field, params[1]);
    else if (rule == 'url')      addRuleURL     (field);
    else if (rule == 'ip')       addRuleIP      (field);
    else if (rule == 'domain')   addRuleDomain  (field);
}

function addRuleRequired(field){
    $("#"+field).prop('required',true);
}

function addRuleEmail(field){
    $("#"+field).attr('type','email');
}

function addRuleNumeric(field){
    $("#"+field).attr('type','number')
                .attr('step','any');
}

function addRuleInteger(field){
    $("#"+field).attr('type','number');
}

function addRuleMin(field,min){
    $("#"+field).attr('pattern','.{' + min + ',}')
                .attr('title', min + ' Or more characters');
}

function addRuleURL(field){
    $("#"+field).attr('pattern','https?://.+')
                .attr('title', 'Needs to be a webpage');
}

function addRuleIP(field){
    $("#"+field).attr('pattern','((^|\\.)((25[0-5])|(2[0-4]\\d)|(1\\d\\d)|([1-9]?\\d))){4}$')
                .attr('title', 'Needs to be an IP');
}

function addRuleDomain($field){
    $("#"+field).attr('pattern','^([a-zA-Z0-9]([a-zA-Z0-9\\-]{0,61}[a-zA-Z0-9])?\\.)+[a-zA-Z]{2,6}$')
                .attr('title', 'Needs to be an IP');
}

 */
