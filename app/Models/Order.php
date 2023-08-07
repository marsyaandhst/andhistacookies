<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $fillable = ['namapenerima', 'nohp', 'namakue', 'totalitem', 'totalharga', 'alamat', 'buktipembayaran', 'status_pembayaran'];

    public function allData()
    {
        return DB::table('orders')->get();
    }

    public function detailDataOrder($id)
    {
        return DB::table('orders')->where('id', $id)->first();
    }

    public function addData($data)
    {
        return DB::table('orders')->insert($data);
    }

    public function product(){
        return $this->belongsTo('App\Models\Product');
    }

    public function deleteDataOrder($id)
    {
        DB::table('orders')
            ->where('id', $id)
            ->delete();
    }
    public function editData($id, $data)
    {
        return DB::table('orders')->where('id', $id)->update($data);
    }
}