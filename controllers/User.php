<?php 

class User {
    public function getAll(Request $request)
    {
        echo $request->data['name'];
    }
}