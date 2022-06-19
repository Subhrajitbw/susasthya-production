<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class KnowYourDisease extends Model
{
    public function save(array $options = [])
    {
        // If no author has been assigned, assign the current user's id as the author of the post
        if (!$this->created_by_user_id && \Auth::user()) {
            $this->created_by_user_id = \Auth::user()->id;
        }

        parent::save();
    }
}
