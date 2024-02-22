<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'is_fraudulent',
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function getSecondaryWalletAttribute()
    {
        $secondaryWalletId = Transaction::where('group_id', $this->group_id)->Where('id', '!=',
            $this->id)->value('wallet_id');
        $secondary         = Wallet::findOrFail($secondaryWalletId);


        return $secondary->name;
    }
}
