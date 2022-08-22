<?php

namespace App\Capital\Interfaces;

use App\User;
use App\Core\Response;

interface EntryInterface
{
    /**
     * Return all Capital Entries by User.
     * 
     * @param  User $user
     * 
     * @return Response
     * 
     */
    public function entriesByUser(User $user);

}