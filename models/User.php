<?php 
class User extends Model{ 
    // protected string $idName = 'email';

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}