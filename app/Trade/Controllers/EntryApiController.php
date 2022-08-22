<?php

namespace App\Trade\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\User;
use App\Trade\Models\Entry;
use App\Trade\Interfaces\EntryInterface;
use App\Trade\Commands\SaveTradeEntryCommand;

/**
 * REST API for Trade Entries
 * Endpoints for Trade Entries are routed here
 */
class EntryApiController extends Controller
{
    protected $entryRepository;
    
    public function __construct(EntryInterface $entryInterface)
    {
        $this->entryRepository = $entryInterface;
    }
    
    /**
     * All the Trade Entries of a User
     *
     * @param Request $request
     * @param $user
     *
     * @return String
     */
    public function index(Request $request, $user)
    {
        $response = $this->entryRepository->entriesByUser(User::find($user));
        
        if ($response->code() != 200) {
            return json_encode([
                'code' => 400,
                'message' => $response->message(),
                'data' => [],
            ]);
        }
        
        return json_encode([
            'code' => 200,
            'message' => $response->message(),
            'entries' => $response->data(),
        ]);
    }
    
    /**
     * Saves a Trade Entry to a User
     *
     * @param Request $request
     * @param int $user
     *
     * @return String
     */
    public function store(Request $request, $user)
    {
        $input = $request->input('trade');
        $entry = new Entry();
        
        $entry->asset_pair = !empty($input['assetPair']) ? $input['assetPair'] : '';
        $entry->entered_at = !empty($input['openingDate']) ? $input['openingDate'] : null;
        $entry->opening_price = !empty($input['openingPrice']) ? $input['openingPrice'] : 0;
        $entry->quantity = !empty($input['quantity']) ? $input['quantity'] : 0;
        $entry->position = !empty($input['position']) ? $input['position'] : 0;
        $entry->closed_at = !empty($input['closingDate']) ? $input['closingDate'] : null;
        $entry->closing_price = !empty($input['closingPrice']) ? $input['closingPrice'] : 0;
        $entry->stop_loss = !empty($input['stopLoss']) ? $input['stopLoss'] : 0;
        $entry->created_by = $user;
        
        $command = new SaveTradeEntryCommand($entry);
        $response = $command->handle();
        
        return $response->toJson();
    }
    
     /**
     * Updates existing Trade Entry of a User
     *
     * @param Request $request
     * @param int $user
     * @param int $trade
     *
     * @return String
     */
    public function update(Request $request, $user, $trade)
    {
        $input = $request->input('trade');
        $entry = Entry::find($trade);
        
        $entry->asset_pair = !empty($input['assetPair']) ? $input['assetPair'] : '';
        $entry->entered_at = !empty($input['openingDate']) ? $input['openingDate'] : null;
        $entry->opening_price = !empty($input['openingPrice']) ? $input['openingPrice'] : 0;
        $entry->quantity = !empty($input['quantity']) ? $input['quantity'] : 0;
        $entry->position = !empty($input['position']) ? $input['position'] : 0;
        $entry->closed_at = !empty($input['closingDate']) ? $input['closingDate'] : null;
        $entry->closing_price = !empty($input['closingPrice']) ? $input['closingPrice'] : 0;
        $entry->stop_loss = !empty($input['stopLoss']) ? $input['stopLoss'] : 0;
        $entry->created_by = $user;
        
        $command = new SaveTradeEntryCommand($entry);
        $response = $command->handle();
        
        return $response->toJson();
    }
}
