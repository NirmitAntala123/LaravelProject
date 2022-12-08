
@extends('dashboard')

@section('title')
Admins - Admin Panel
@endsection

@section('styles')
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    
@endsection


@section('content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Admins</h4>
                <ul class="breadcrumbs pull-left">
                    {{-- <li><a href="{{ route('dashboard') }}">Dashboard</a></li> --}}
                    <li><span>All Admins</span></li>
                    
                </ul>
                
            </div>
            <p id="massage"></p>
        </div>
        {{-- <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div> --}}
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">Admins List</h4>
                    {{-- <x-home /> --}}
                    <p class="float-right mb-2">
                        @if (Auth::guard('admin')->user()->can('admin.create'))
                            <a class="btn btn-primary text-white" href="{{ route('admins.create') }}">Create New Admin</a>
                            <a class="btn btn-light" href="{{ route('getDeleteusers') }}" title="View Deleted Users"> <i class="fas fa-recycle text-danger fa-lg"></i></a>
                        @endif
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        {{-- @include('backend.layouts.partials.messages') --}}
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">Sl</th>
                                    <th width="10%">Name</th>
                                    <th width="10%">Email</th>
                                    <th width="40%">Roles</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($admins as $admin)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        {{-- @php dump($admin->roles);@endphp --}}
                                        @foreach ($admin->roles as $role)
                                        
                                            <span class="badge badge-info mr-1">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if (Auth::guard('admin')->user()->can('admin.edit'))
                                            <a class="btn btn-success text-white" href="{{ route('admins.edit', $admin->id) }}">Edit</a>
                                        @endif
                                        
                                        @if (Auth::guard('admin')->user()->can('admin.delete'))
                                        <a class="btn btn-danger text-white" href="{{ route('admins.destroy', $admin->id) }}"
                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $admin->id }}').submit();">
                                            Delete
                                        </a>
                                        <form id="delete-form-{{ $admin->id }}" action="{{ route('admins.destroy', $admin->id) }}" method="POST" style="display: none;">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                        <td>
                                            <input id="{{$admin->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $admin->status ? 'checked' : '' }}>
                                         </td>
                                        @endif
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>

@endsection


@section('scripts')
     <!-- Start datatable js -->
     <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
     <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
     
     <script>
         /*================================
        datatable active
        ==================================*/
        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: true
            });
        }
        
     </script>
@endsection