<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderHeader;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->Product = new Product();
        $this->Order = new Order();
    }

    public function index()
    {
        $data = [
            'product' => $this->Product->get()
        ];
        return view('dashboard.v_dashboard', $data);
    }

    public function detail($id)
    {
        if (!$this->Product->detailData($id)) {
            abort(404);
        }
        $data = [
            'product' => $this->Product->detailData($id),
        ];
        return view('dashboard.v_detailproduk', $data);
    }

    public function add()
    {
        return view('dashboard.v_addproduk');
    }

    public function insert()
    {
        Request()->validate([
            'id' => 'nullable|unique:products,id|min:1|max:6',
            'no' => 'required|integer',
            'namakue' => 'required',
            'stock' => 'required|integer',
            'harga' => 'required|integer',
            'photo' => 'required|mimes:jpg,jpeg,png,webp|max:1000',
            'deskripsi' => 'required',
        ], [
            'id.required' => 'wajib diisi !!',
            'id.unique' => 'id Sudah Ada !!',
            'id.min' => 'Min 1 Karakter',
            'id.max' => 'Max 6 Karakter'
        ]);

        //jika validasi tidak ada maka lakukan simpan data
        //upload photo
        $file = Request()->photo;
        $fileName = Request()->namakue . '.' . $file->extension();
        $file->move(public_path('fotokue'), $fileName);

        $data = [
            'id' => Request()->id,
            'no' => Request()->no,
            'namakue' => Request()->namakue,
            'stock' => Request()->stock,
            'harga' => Request()->harga,
            'photo' => $fileName,
            'deskripsi' => Request()->deskripsi,
        ];

        $this->Product->addData($data);
        return redirect()->route('admin')->with('pesan', 'Data Successfully Added !!');
    }

    public function edit($id)
    {
        if (!$this->Product->detailData($id)) {
            abort(404);
        }
        $data = [
            'product' => $this->Product->detailData($id),
        ];
        return view('dashboard.v_editproduk', $data);
    }
    public function update($id)
    {
        Request()->validate([
            'id' => 'nullable|min:1|max:6',
            'no' => 'required|integer',
            'namakue' => 'required',
            'stock' => 'required',
            'harga' => 'required|integer',
            'photo' => 'mimes:jpg,jpeg,png,webp|max:1000',
            'deskripsi' => 'required',
        ], [
            'id.required' => 'wajib diisi !!',
            'id.unique' => 'id Sudah Ada !!',
            'id.min' => 'Min 1 Karakter',
            'id.max' => 'Max 6 Karakter'
        ]);

        //jika validasi tidak ada maka lakukan simpan data
        if (Request()->gambar <> "") {
            //jika ingin ganti foto
            //upload photo
            $file = Request()->photo;
            $fileName = Request()->id . '.' . $file->extension();
            $file->move(public_path('fotokue'), $fileName);

            $data = [
                'id' => Request()->id,
                'no' => Request()->no,
                'namakue' => Request()->namakue,
                'stock' => Request()->stock,
                'harga' => Request()->harga,
                'photo' => $fileName,
                'deskripsi' => Request()->deskripsi,
            ];

            $this->Product->editData($id, $data);
        } else {
            //jika tidak ingin ganti foto
            $data = [
                'id' => Request()->id,
                'no' => Request()->no,
                'namakue' => Request()->namakue,
                'stock' => Request()->stock,
                'harga' => Request()->harga,
                'deskripsi' => Request()->deskripsi,
            ];
            $this->Product->editData($id, $data);
        }
        return redirect()->route('admin')->with('pesan', 'Data Successfully Updated !!');
    }

    public function delete($id)
    {
        
        $produk = $this->Product->detailData($id);

        if ($produk->photo != "") {
            $photoPath = public_path('fotokue') . '/' . $produk->photo;
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        $this->Product->deleteData($id);
        return redirect()->route('admin')->with('pesan', 'Data Deleted Successfully.');
    }

    /////////////////////////////////////////////////Order//////////////////////////////

    public function showorder()
    {
        $data = [
            'order' => $this->Order->allData()
        ];
        return view('dashboard.pesanan', $data);
    }

    public function detailorder($id)
    {
        if (!$this->Order->detailDataOrder($id)) {
            abort(404);
        }
        $data = [
            'order' => $this->Order->detailDataOrder($id),
        ];
        return view('dashboard.detailpesanan', $data);
    }

    public function deletepesanan($id)
    {
        $orderHeader = OrderHeader::findOrFail($id);

        OrderDetail::where('order_id', $id)->delete();

        $orderHeader->delete();

        return redirect()->route('daftarpesanan')->with('pesan', 'Data Deleted Successfully.');
    }


    public function updatestatus(Request $request, $orderId)
    {
        $orderHeader = OrderHeader::findOrFail($orderId);
        $orderHeader->status_pembayaran = $request->status_pembayaran;
        $orderHeader->save();

        return view('dashboard.pesanan');

    }

    public function adminGetOrderHeaders(Request $request)
    {
        $userId = auth()->user()->id;
        if ($request->ajax()) {
            $orderHeaders = OrderHeader::get();

            foreach ($orderHeaders as $orderHeader) {
                $statusPembayaran = $orderHeader->status_pembayaran;
                $orderHeader->status_pembayaran = $statusPembayaran;
            }

            return datatables()->of($orderHeaders)->toJson();
        }

        return view('dashboard.pesanan');
    }

    public function adminGetOrderDetails($orderId)
    {
        $orderDetails = DB::table('order_details as a')
            ->join('products as b', 'b.id', '=', 'a.product_id')
            ->select(
                'a.qty',
                'b.namakue',
                'b.photo',
                'b.deskripsi',
                'b.harga',
                'b.stock'
            )
            ->where('a.order_id', '=', $orderId)
            ->get();
        return response()->json($orderDetails);
    }

}