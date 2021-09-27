<?php 

class Post extends Model {
    public function user()
    {
        return $this->hasOne(User::class);
    }
}