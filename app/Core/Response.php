<?php

namespace App\Core;

class Response {
    protected $code;
    protected $message;
    protected $data;
    
    public function __construct($code, $message, $data)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }
    
    public function code()
    {
        return $this->code;
    }
    
    public function message()
    {
        return $this->message;
    }
    
    public function data()
    {
        return $this->data;
    }
    
    /**
     * Transforms the Response data into an array.
     * 
     * @return array
     * 
     */
    public function toArray()
    {
        return array(
            'code' => $this->code,
            'message' => $this->message,
            'data' => $this->data
        );
    }
    
    /**
     * Transforms the Response data into JSON Format.
     * 
     * @return string
     * 
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
