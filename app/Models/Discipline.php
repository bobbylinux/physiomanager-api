<?php

namespace App\Models;

class Discipline extends BaseModel
{
    /**
     * Get the doctors for discipline.
     */
    public function doctors()
    {
        return $this->hasMany('App\Models\Doctor');
    }

}
