<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderHeader;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->product = new Product();
        $this->order = new Order();
    }

    public function showproduct()
    {
        $data = [
            "product" => $this->product->get()
        ];
        return view('home', $data);
    }

    public function showproductdetail($id)
    {
        $data = [
            "product" => $this->product->detailData($id)
        ];
        return view('detailproduct', $data);
    }

    public function pembayaranproduct($id)
    {
        $data = [
            "product" => $this->product->detailData($id)
        ];
        return view('pembayaran', $data);
    }

    // public function insertpembayaran()
    // {
    //     Request()->validate([
    //         'namapenerima' => 'required',
    //         'nohp' => 'required',
    //         'namakue' => 'required',
    //         'totalitem' => 'required|integer',
    //         'totalharga' => 'required|integer',
    //         'alamat' => 'required',
    //         'buktipembayaran' => 'required|mimes:jpg,jpeg,png,webp|max:1000',
    //     ], [
    //         'id.required' => 'wajib diisi !!',
    //         'id.unique' => 'id Sudah Ada !!',
    //         'id.min' => 'Min 1 Karakter',
    //         'id.max' => 'Max 6 Karakter',
    //     ]);

    //     //jika validasi tidak ada maka lakukan simpan data
    //     //upload photo
    //     $file = Request()->buktipembayaran;
    //     $fileName = Request()->namapenerima . '.' . $file->extension();
    //     $file->move(public_path('buktipembayaran'), $fileName);

    //     $userId = auth()->user()->id;

    //     $data = [
    //         'id' => Request()->id,
    //         'id_user' => $userId,
    //         'namapenerima' => Request()->namapenerima,
    //         'nohp' => Request()->nohp,
    //         'namakue' => Request()->namakue,
    //         'totalitem' => Request()->totalitem,
    //         'totalharga' => Request()->totalharga,
    //         'alamat' => Request()->alamat,
    //         'buktipembayaran' => $fileName,
    //     ];

    //     $this->order->addData($data);
    //     return redirect()->route('history')->with('pesan', 'Data Berhasil Ditambahkan !!');
    // }

    public function insertpembayaran()
    {
        Request()->validate([
            'namapenerima' => 'required',
            'nohp' => 'required|numeric|digits_between:11,13',
            'alamat' => 'required',
            'buktipembayaran' => 'required|mimes:jpg,jpeg,png,webp|max:1000',
        ], [
            'nohp.required' => 'Nomor HP wajib diisi.',
            'nohp.numeric' => 'Nomor HP harus berupa angka.',
            'nohp.digits_between' => 'Nomor HP harus terdiri dari 11 hingga 13 digit.',
        ]);

        $file = Request()->buktipembayaran;
        $fileName = Request()->namapenerima . '.' . $file->extension();
        $file->move(public_path('buktipembayaran'), $fileName);

        $userId = auth()->user()->id;

        $invoiceNo = 'INV-' . date('YmdHis') . '-' . rand(1000, 9999);

        $orderHeader = new OrderHeader();
        $orderHeader->invoice_no = $invoiceNo;
        $orderHeader->id_user = $userId;
        $orderHeader->namapenerima = Request()->namapenerima;
        $orderHeader->nohp = Request()->nohp;
        $orderHeader->totalharga = 0;
        $orderHeader->tanggalpembelian = date('Y-m-d H:i:s');
        $orderHeader->alamat = Request()->alamat;
        $orderHeader->buktipembayaran = $fileName;
        $orderHeader->status_pembayaran = 'Menunggu Pembayaran';
        $orderHeader->save();

        $cart = Cart::where('user_id', $userId)->first();
        if (!$cart) {
            return redirect()->back()->with('pesan', 'Shopping Cart Not Found.');
        }

        $cartItems = CartItem::where('cart_id', $cart->id)->get();
        if (!$cartItems) {
            return redirect()->back()->with('pesan', 'Item in Shopping Cart Not Found.');
        }

        $totalHarga = 0;
        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);
            if (!$product) {
                return redirect()->back()->with('pesan', 'Product with ID ' . $item->product_id . ' not found.');
            }

            // update totalharga
            $totalHarga += $product->harga * $item->quantity;

            // insert ke order_details
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $orderHeader->id;
            $orderDetail->product_id = $item->product_id;
            $orderDetail->qty = $item->quantity;
            $orderDetail->save();

            // update stock
            $product->stock -= $item->quantity;
            $product->save();
        }

        $orderHeader->totalharga = $totalHarga;
        $orderHeader->save();

        $cartItems->each->delete();
        $cart->delete();

        session()->flash('success', 'Checkout and Payment Successful !!');

        return redirect()->route('getOrderHeaders');
    }




    public function history()
    {
        $userId = auth()->user()->id;

        $data = [
            "order" => OrderHeader::where('id_user', $userId)->get(),
        ];

        return view('history', $data);
    }

    public function getOrderDetails($orderId)
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
    public function getOrderHeaders(Request $request)
    {
        $userId = auth()->user()->id;
        if ($request->ajax()) {
            $orderHeaders = OrderHeader::where('id_user', $userId)->get();
            return datatables()->of($orderHeaders)->toJson();
        }

        return view('history');
    }



    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        $cartItem = CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity
        ]);

        if ($cartItem) {
            return response()->json([
                'message' => 'Produk berhasil ditambahkan ke keranjang.',
                'product' => $product,
            ]);
        } else {
            return response()->json([
                'message' => 'Gagal menambahkan produk ke keranjang.',
            ], 500);
        }
    }

    public function getCartData()
    {
        $userCart = auth()->user()->cart;
        $cartItems = $userCart ? $userCart->cartItems()->with('product')->get() : [];

        return response()->json([
            'user_id' => auth()->user()->id,
            'cart' => $cartItems,
        ]);
    }

    public function showShoppingCart()
    {
        $userCart = Auth::user()->cart;
        $cartItems = $userCart ? $userCart->cartItems()->with('product')->get() : [];

        $totalPrice = 0;
        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->quantity * $cartItem->product->harga;
        }

        return view('shoppingcart', compact('cartItems', 'totalPrice'));
    }

    public function updateQuantity(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::findOrFail($cartItemId);

        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'message' => 'Quantity Successfully Updated!',
            'cartItem' => $cartItem
        ]);
    }

    public function removeFromCart($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);

        if ($cartItem->cart->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Anda tidak memiliki akses untuk menghapus produk ini.',
            ], 403);
        }

        if ($cartItem->delete()) {
            return response()->json([
                'message' => 'Produk dalam keranjang berhasil dihapus.',
            ]);
        } else {
            return response()->json([
                'message' => 'Gagal menghapus produk dari keranjang.',
            ], 500);
        }
    }

    public function saveCheckoutData(Request $request)
    {
        $checkoutItems = $request->input('checkoutItems');
        $totalPayment = $request->input('totalPayment');
        $errorMessage = null;

        foreach ($checkoutItems as $item) {
            $productId = $item['productId'];
            $quantity = $item['quantity'];

            $product = Product::find($productId);

            if ($quantity > $product->stock) {
                $errorMessage = 'Quantity for product ' . $product->namakue . ' exceeds the available stock.';
                break;
            }
        }

        if ($errorMessage) {
            Alert::html('Quantity lebih dari stock product', $errorMessage, 'error');
            return response()->json(['error' => $errorMessage], 422);
        }

        session([
            'checkoutData' => [
                'checkoutItems' => $checkoutItems,
                'totalPayment' => $totalPayment,
            ]
        ]);

        return response()->json(['message' => 'Checkout data saved successfully.']);
    }




    public function checkout()
    {
        $checkoutData = session('checkoutData');
        $checkoutItems = $checkoutData['checkoutItems'];

        $totalPrice = 0;
        foreach ($checkoutItems as $item) {
            $totalPrice += $item['harga'];
        }

        return view('checkout', compact('checkoutData', 'checkoutItems', 'totalPrice'));
    }

    public function getProductData(Request $request)
    {
        $productId = $request->input('productId');

        $product = Product::find($productId);

        return response()->json(['product' => $product]);
    }
}
