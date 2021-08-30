<?php 

class Response { 
    public function json(array $data, int $status = 200)
    {
        header("HTTP/1.1 $status");
        echo json_encode($data);
    }
}