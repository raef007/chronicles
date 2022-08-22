<?php

namespace App\Capital\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\User;
use App\Capital\Models\Entry;
use App\Capital\Interfaces\EntryInterface;
use App\Capital\Commands\ChangeEntryStatusCommand;

class EntryApiController extends Controller
{
    protected $entryRepository;
    
    public function __construct(EntryInterface $entryInterface)
    {
        $this->entryRepository = $entryInterface;
    }
    
    /**
     * REST API for Capital Entries /capital/entries
     * It should give all the Capital entries of the User
     *
     * @param Request $request
     * @param $user
     *
     * @return string
     */
    public function index(Request $request, $user)
    {
        $response = $this->entryRepository->entriesByUser(User::find($user));
        
        if ($response->code() != 200) {
            return json_encode([
                'code' => 400,
                'message' => $response->message(),
                'data' => $response->data(),
            ]);
        }
        
        return json_encode([
            'code' => 200,
            'message' => $response->message(),
            'data' => $response->data(),
        ]);
    }
}
