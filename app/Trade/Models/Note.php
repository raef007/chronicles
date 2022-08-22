<?php
namespace App\Trade\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trade_notes';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'entry',
        'remarks'
    ];
    
    /**
     * Define the Entity relation as Journal entry has many Notes.
     *
     * @return Entry
     */
    public function notes()
    {
        return $this->belongsTo('App\Trade\Models\Note', 'entry');
    }
}