<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHeader extends Model
{
    use HasFactory;

    protected $table = 'order_headers';

    protected $fillable = [
        'id_user',
        'invoice_no',
        'namapenerima',
        'nohp',
        'totalharga',
        'alamat',
        'buktipembayaran',
        'tanggalpembayaran',
        'status_pembayaran',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}