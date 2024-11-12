<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Transaction
 *
 * @property $id
 * @property $user_id
 * @property $payment_method_id
 * @property $amount
 * @property $description
 * @property $transaction_date
 * @property $created_at
 * @property $updated_at
 *
 * @property PaymentMethod $paymentMethod
 * @property User $user
 * @property TransactionTotal[] $transactionTotals
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Transaction extends Model
{

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'payment_method_id', 'category_id', 'amount', 'type', 'description', 'transaction_date'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentMethod()
    {
        return $this->belongsTo(\App\Models\PaymentMethod::class, 'payment_method_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactionTotals()
    {
        return $this->hasMany(\App\Models\TransactionTotal::class, 'id', 'last_transaction_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public static function getDistinctPaymentMethods()
    {
        return self::join('payment_methods', 'transactions.payment_method_id', '=', 'payment_methods.id')
            ->where('transactions.user_id', Auth::id())
            ->select('payment_methods.id', 'payment_methods.method_name')
            ->distinct()
            ->pluck('method_name', 'id');
    }

    // Fungsi untuk mendapatkan kategori yang pernah digunakan
    public static function getDistinctCategories()
    {
        return self::join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', Auth::id())
            ->select('categories.id', 'categories.name')
            ->distinct()
            ->pluck('name', 'id');
    }
}
