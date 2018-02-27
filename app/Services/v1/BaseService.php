<?php
namespace App\Services\v1;

use Validator;

abstract class BaseService
{
    protected $supportedIncludes = array();
    protected $clauseProperties = array();
    protected $rules = array();

    public function validate($item) {
        $validator = Validator::make($item, $this->rules);
        $validator->validate();
    }

    protected function getWhereClause($parameters)
    {
        $clause = array();

        foreach ($this->clauseProperties as $property) {
            if (in_array($property, array_keys($parameters))) {
                $clause[$property] = $parameters[$property];
            }
        }

        return $clause;
    }

    protected function getWithKeys($parameters)
    {
        $withKeys = array();

        if (isset($parameters['include'])) {
            $includeParams = explode(",", $parameters['include']);
            $includes = array_intersect($this->supportedIncludes, $includeParams);
            $withKeys = array_keys($includes);
        }

        return $withKeys;

    }

}