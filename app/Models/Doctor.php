<?php
namespace App\Models;

class Doctor extends BaseModel
{
    /**
     * Get the doctor discipline.
     */
    public function discipline()
    {
        return $this->belongsTo('App\Models\Discipline');
    }

}
