<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerSegment extends BaseModel
{
    protected $fillable = [
        'customer_id',
        'segment_id'
    ];

    /**
     * Get the customer that owns the customer segment.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the segment that owns the customer segment.
     */
    public function segment()
    {
        return $this->belongsTo(Segment::class);
    }
}
