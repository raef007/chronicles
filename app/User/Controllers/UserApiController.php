<?php

namespace App\User\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\User;
use App\Capital\Interfaces\EntryInterface As CapitalInterface;
use App\Trade\Interfaces\EntryInterface As TradeInterface;

/**
 * REST API for User
 * Endpoints for Users are routed to this class
 */
class UserApiController extends Controller
{
    protected $capitalRepository;
    protected $tradeRepository;
    
    public function __construct(TradeInterface $tradeInterface, CapitalInterface $capitalInterface)
    {
        $this->capitalRepository = $capitalInterface;
        $this->tradeRepository = $tradeInterface;
    }
    
    public function index(Request $request, $user)
    {
        return 1;
    }
    
    /**
     * The Profit and Loss Summary of all Trades and Capital
     * of a User. It has Total Capital, Total Profit and Loss
     *
     * @param Request $request
     * @param int $user
     *
     * @return String
     */
    public function getPnlSummary(Request $request, $user)
    {
        $capitalEntries = $this->capitalRepository->entriesByUser(User::find($user));
        $tradeEntries = $this->tradeRepository->entriesByUser(User::find($user));
        $errorMessages = [];
        
        /* An error occured in either Capital or Trade Entry Database call */
        if (($capitalEntries->code() != 200) ||
            ($tradeEntries->code() != 200)) {
            $errorMessages = array_merge($capitalEntries->message(), $tradeEntries.message());
            
            return json_encode([
                'code' => 400,
                'message' => $errorMessages,
                'data' => [],
            ]);
        }
        
        $summary = new \stdClass();
        
        /* Computes for the total Capital */
        $summary->total_capital = 0;
        foreach ($capitalEntries->data() as $capital) {
            $summary->total_capital += $capital->totalAmount();
        }
        
        /* Computes for the Profit and Loss */
        $summary->total_pnl =  0;
        foreach ($tradeEntries->data() as $trades) {
            $summary->total_pnl += $trades->profitAndLossAmount();
        }
        
        return json_encode([
            'code' => 200,
            'message' => 'Success',
            'summary' => $summary,
        ]);
    }
}
