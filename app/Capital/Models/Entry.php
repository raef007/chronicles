<?php
namespace App\Capital\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'capital_entry';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user',
        'amount',
        'fee',
        'method',
        'remarks',
        'currency',
        'created_at'
    ];
    
    /**
     * Defines relationship with User as "User has many Capital Entries"
     *
     * @var array
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user')->withTrashed();
    }
    
    /**
     * Computes the total Capital added including Fees
     *
     * @var array
     */
    public function totalAmount()
    {
        return $this->amount + $this->fee;
    }
}