<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    /**
     * Get the session therapy.
     */
    public function therapy()
    {
        return $this->belongsTo('App\Models\Therapy');
    }
    /**
     * Get the session physiotherapist.
     */
    public function physiotherapist()
    {
        return $this->belongsTo('App\Models\Physiotherapist');
    }
}
