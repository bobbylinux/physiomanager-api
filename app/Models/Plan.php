<?php
namespace App\Models;


class Plan extends BaseModel
{
    /**
     * Get the plan patient.
     */
    public function patient()
    {
        return $this->hasOne('App\Models\Patient');
    }
    /**
     * Get the plan work result.
     */
    public function work_result()
    {
        return $this->hasOne('App\Models\WorkResult');
    }
    /**
     * Get the plan pain
     */
    public function pain()
    {
        return $this->hasOne('App\Models\Pain');
    }
    /**
     * Get the plan mobility
     */
    public function mobility()
    {
        return $this->hasOne('App\Models\Mobility');
    }
}
