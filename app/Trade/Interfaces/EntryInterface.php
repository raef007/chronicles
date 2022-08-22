<?php

namespace App\Trade\Interfaces;

use App\User;
use App\Core\Response;

interface EntryInterface
{
    /**
     * Return all Trade Entries by User.
     * 
     * @param  User $user
     * @return Response
     * 
     */
    public function entriesByUser(User $user);

}