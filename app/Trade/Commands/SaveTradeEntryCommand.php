<?php

namespace App\Trade\Commands;

use Illuminate\Foundation\Http\FormRequest;
use App\Trade\Models\Entry;
use App\Core\Response;

use Validator;

/**
 * Validates the inputs for a Trade entry
 * and save it to the database
 */
class SaveTradeEntryCommand {
    
    /** @var string */
    protected $status;
    
    /** @var Validator */
    protected $validator;
    
    public function __construct(Entry $entry)
    {
        $this->entry = $entry;
        $this->validator = null;
    }
    
    /**
     * Main Processing to handle the Command
     * 
     * @return Response
     */
    public function handle()
    {
        $validation = $this->validate();
        
        if ($validation->fails()) {
            return new Response(400, $validation->errors()->all(), []);
        }
        
        try {
            $this->entry->save();
            return new Response(200, ['Success'], [$this->entry]);
            
        } catch (Exception $error) {
            return new Response(500, $error->getMessage(), []);
        }
    }
    
    /**
     * Validates the input
     * 
     * @return Response
     */
    private function validate()
    {
        $rules = [
            'asset_pair' => 'required',
            'entered_at' => 'required',
            'opening_price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'position' => 'required',
            'closing_price' => 'numeric',
            'stop_loss' => 'numeric',
        ];

        $attributes = [
            'asset_pair' => 'Asset Pair',
            'entered_at' => 'Opening Date',
            'opening_price' => 'Opening Price',
            'quantity' => 'Quantity',
            'position' => 'Position',
            'closing_price' => 'Closing Price',
            'stop_loss' => 'Stop Loss',
        ];

        $message = [
            'asset_pair.required' => ':attribute is required.',
            'opening_date.required' => ':attribute is required.',
            'opening_price.required' => ':attribute is required.',
            'quantity.required' => ':attribute is required.',
        ];
        
        $this->validator = Validator::make($this->entry->getAttributes(), $rules, $message);
        $this->validator->setAttributeNames($attributes);

        return $this->validator;
    }
}
