<?php

namespace App\Trade\Repositories;

use App\User;
use App\Core\Response;
use App\Trade\Models\Entry;
use App\Trade\Interfaces\EntryInterface;
use Carbon\Carbon;
use DB;

class EntryEloquent implements EntryInterface
{
    /**
     * Return all Trade Entries by User.
     * 
     * @param  User $user
     * @return Response
     * 
     */
    public function entriesByUser(User $user)
    {
        try {
            $entries = Entry::where('created_by', 1)
                ->orderBy('created_at', 'DESC');
            
            return new Response(200, ['Success'], $entries->get());

        } catch (Exception $error) {
            return new Response(500, $error->getMessage(), $entries->get());
        }
    }

}
