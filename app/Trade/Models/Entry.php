<?php
namespace App\Trade\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trade_entry';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'entered_at',
        'closed_at',
        'asset_pair',
        'opening_price',
        'closing_price',
        'quantity',
        'stop_loss',
        'status',
        'position',
        'is_stopped_out',
        'created_by'
    ];
    
    /**
     * Establish connection with Trade Notes as "One Trade has many Notes"
     * 
     * @return Note
     */
    public function notes()
    {
        return $this->hasMany('App\Trade\Models\Note', 'entry', 'id');
    }
    
    /**
     * Establish connection with User as "Trade Entry has a user"
     * 
     * @return User
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'created_by')->withTrashed();
    }
    
    /**
     * Calculates the total cost of the trade
     * 
     * @return float
     */
    public function amount()
    {
        return $this->quantity * $this->opening_price;
    }
    
    /**
     * Calculates the Profit and Loss percent of the Trade
     * 
     * @return float
     */
    public function profitAndLossPercent()
    {
        /* Short Position */
        if ("Short" == $this->position) {
            return (($this->opening_price - $this->closing_price) / $this->opening_price) * 100;
        }
        
        return (($this->closing_price - $this->opening_price) / $this->opening_price) * 100;
    }
    
    /**
     * Calculates the Profit and Loss amount of the Trade
     * 
     * @return float
     */
    public function profitAndLossAmount()
    {
        $amount = $this->amount();
        $pnlPercent = $this->profitAndLossPercent();
        
        if ("Short" == $this->position) {
            return ($amount + ($amount * ($pnlPercent / 100))) - $amount;
        }
        
        return ($amount + ($amount * ($pnlPercent / 100))) - $amount;
    }
}