<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    //


    protected $table = 'notices';

    protected $fillable = [
        'infringing_title',
        'infringing_link',
        'original_link',
        'original_description',
        'template',
        'content_removed',
        'provider_id'
    ];

    public function recipient()
    {
        return $this->belongsTo('App\Provider', 'provider_id');
    }

    public function getRecipientEmail()
    {
        return $this->recipient->copyright_email;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getOwnerEmail()
    {
        return $this->user->email;
    }

    /**
     * @param array $attributes
     * @return static
     */
    public static function open(array $attributes)
    {
        return new static ($attributes);
    }


    /**
     * @param $template
     */
    public function useTemplates($template)
    {
        $this->template = $template; // this is a table field

        return $this;
    }
}
