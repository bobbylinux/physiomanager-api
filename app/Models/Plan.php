<?php
namespace App\Models;


class Plan extends BaseModel
{
    /**
     * Get the plan patient.
     */
    public function patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }
    /**
     * Get the plan work result.
     */
    public function work_result()
    {
        return $this->belongsTo('App\Models\WorkResult');
    }
    /**
     * Get the plan pain
     */
    public function pain()
    {
        return $this->belongsTo('App\Models\Pain');
    }
    /**
     * Get the plan mobility
     */
    public function mobility()
    {
        return $this->belongsTo('App\Models\Mobility');
    }
    /**
     * Get the plan sessions.
     */
    public function sessions()
    {
        return $this->hasMany('App\Models\Session');
    }
}
