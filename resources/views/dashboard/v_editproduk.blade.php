@extends('dashboard.v_template')
@section('title', 'Edit Moisturizer')

@section('content')
<form action="/admin/update/{{ $product -> id}}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="content">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Product Id</label>
                    <input name="id" class="form-control" value="{{$product->id}}" readonly>
                        <div class="text-danger">
                            @error('id')
                                {{ $message }}
                            @enderror
                        </div>
                </div>

                <div class="form-group">
                    <label>No</label>
                    <input name="no" class="form-control" value="{{$product->no}}">
                    <div class="text-danger">
                            @error('no')
                                {{ $message }}
                            @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Product Name</label>
                    <input name="namakue" class="form-control" value="{{$product->namakue}}">
                        <div class="text-danger">
                                @error('namakue')
                                    {{ $message }}
                                @enderror
                        </div>
                </div>

                <div class="form-group">
                    <label>Price</label>
                    <input name="harga" class="form-control" value="{{$product->harga}}">
                        <div class="text-danger">
                                @error('harga')
                                    {{ $message }}
                                @enderror
                        </div>
                </div>

                <div class="form-group">
                    <label>Stock</label>
                    <input name="stock" class="form-control" value="{{$product->stock}}">
                        <div class="text-danger">
                                @error('stock')
                                    {{ $message }}
                                @enderror
                        </div>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <input name="deskripsi" class="form-control" value="{{$product->deskripsi}}">
                        <div class="text-danger">
                                @error('deskripsi')
                                    {{ $message }}
                                @enderror
                        </div>
                </div>


                <div class="col-sm-12">
                    <div class="col-sm-4">
                        <img src="{{url('fotokue/',$product->photo)}}" width="100px">
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Change Photo</label>
                            <input type="file" name="photo" class="form-control" value="{{$product->photo}}">
                                <div class="text-danger">
                                        @error('photo')
                                            {{ $message }}
                                        @enderror
                                </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="col-sm-12">
                    <div class="form-group">
                    <button class="btn btn-primary btn-sm" style="margin-top: 40px;">Save</button>
                    </div>
                </div>
                

            </div>
        </div>
    </div>
    
    

</form>
@endsection