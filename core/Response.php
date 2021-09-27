<?php 

class Response { 
    public function json(array $data, int $status = 200)
    {
        header("HTTP/1.1 $status");

        $result = [];
        foreach ($data as $key => $value) {
            if (is_object($value)) {
                $result[$key] = $value->getData();
            } else {
                $result[$key] = $value;
            }
        }

        echo json_encode($result);
    }
}