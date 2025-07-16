<?php

namespace App\Models;

class CampaignUser extends BaseModel
{
    protected $fillable = [
        'campaign_id',
        'user_id'
    ];

    /**
     * Get the campaign that owns the campaign user.
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Get the user that owns the campaign user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
