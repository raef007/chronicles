<?php

namespace App\Trade\Commands;

use Illuminate\Foundation\Http\FormRequest;
use App\Trade\Models\Entry;
use App\Core\Response;

use Validator;

class ChangeEntryStatusCommand {
    protected $status;
    protected $validator;
    
    public function __construct(Entry $entry, $status)
    {
        $this->entry = $entry;
        $this->status = $status;
        $this->validator = null;
    }
    
    public function handle()
    {
        $validation = $this->validate();
        
        if ($validation->fails()) {
            return new Response(1, json_encode($validation->messages), []);
        }
        
        try {
            $this->entry->status = $this->status;
            $this->entry->save();
            
            return new Response(0, 'Success', [$this->entry]);
            
        } catch (Exception $error) {
            return new Response(1, $error->getMessage(), []);
        }
    }
    
    public function validate()
    {
        $rules = [
            'status' => 'required'
        ];

        $attributes = [
            'status' => 'Status'
        ];

        $message = [
            'status.required' => ':attribute is required.',
        ];

        $this->validator = Validator::make($this->matter->getAttributes(), $rules, $message);
        $this->validator->setAttributeNames($attributes);

        return $this->validator;
    }
}
