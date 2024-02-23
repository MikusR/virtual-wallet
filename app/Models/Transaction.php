<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'type',
        'wallet_id',
        'is_fraudulent',
        'group_id'
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function getSecondaryWalletAttribute(): string
    {
        $secondaryWalletId = Transaction::where('group_id', $this->group_id)->Where('id', '!=',
            $this->id)->value('wallet_id');
        if ($secondaryWalletId === null) {
            return 'none';
        }
        $secondary = Wallet::findOrFail($secondaryWalletId);

        return $secondary->name;
    }
}
