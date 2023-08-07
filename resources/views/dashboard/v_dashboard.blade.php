<!DOCTYPE html>
<html>
  @include('dashboard.head')
  <body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="../../index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A</b>LT</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Andhista Cookies</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu">
              </li>
              <!-- Tasks: style can be found in dropdown.less -->
                  </ul>
                </a>
              </li>
              <!-- User Account: style can be found in dropdown.less -->
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
            </ul>
          </div>
        </nav>
      </header>
      <!-- =============================================== -->
      @include('dashboard.sidebar')
      <!-- =============================================== -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            @yield('title')
          </h1>
        </section>
        <!-- Main content -->
        <section class="content">
          @yield('content')
          <a href="/admin/add" class="btn btn-primary btn-sm">Add</a> <br>
            @if (session('pesan'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                {{session('pesan')}}
            </div>
            @endif
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Product Id</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Photo</th>
                        <th width="200px">Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($product as $item)
                  <tr>
                      <th>{{ $item->no }}</th>
                      <th>{{ $item->id }}</th>
                      <th>{{ $item->namakue }}</th>
                      <th>{{ $item->deskripsi }}</th>
                      <th>{{ $item->harga }}</th>
                      <th>{{ $item->stock }}</th>
                      <td><img src="{{url('fotokue/',$item->photo)}}" width="100px"></td>
                      <th>
                        <a href="/admin/detailproduk/{{ $item->id }}" class="btn btn-sm btn-success">Details</a>
                        <a href="/admin/edit/{{ $item->id }}" class="btn btn-sm btn-warning">Edit</a>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete{{ $item->id}}">
                          Delete
                        </button>
                      </th>
                  </tr>
                  @endforeach
              </tbody>
            </table>
            @foreach ($product as $data)
    <div class="modal modal-danger fade" id="delete{{ $data->id}}">
          <div class="modal-dialog modal-sm" >
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{$data->namakue }}</h4>
              </div>
              <div class="modal-body">
                <p>Are You Sure You Want to Remove this Product?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">No</button>
                <a href="/admin/delete/{{ $data->id}}" class="btn btn-outline">Yes</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

@endforeach
        </section>
      </div>
      <!-- <footer class="main-footer">
        <strong>Batary 2023.</strong> All rights reserved.
      </footer> -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>

      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      
        <!-- /.control-sidebar-menu -->

        
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

@include('dashboard.script')
</body>
</html>
