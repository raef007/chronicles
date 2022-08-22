<?php

namespace App\Capital\Repositories;

use App\User;
use App\Core\Response;
use App\Capital\Models\Entry;
use App\Capital\Interfaces\EntryInterface;
use Carbon\Carbon;
use DB;

class EntryEloquent implements EntryInterface
{
    /**
     * Return all Capital Entries by User.
     * 
     * @param  User $user
     * 
     * @return Response
     * 
     */
    public function entriesByUser(User $user)
    {
        try {
            $entries = Entry::where('user', 1)
                ->orderBy('created_at', 'DESC');
            
            return new Response(200, ['Success'], $entries->get());

        } catch (Exception $error) {
            return new Response(500, $error->getMessage(), $entries->get());
        }
    }

}
