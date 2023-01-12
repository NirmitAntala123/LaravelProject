
@extends('dashboard')
@section('title')
Manage CompanyData
@endsection

@section('styles')
<style>
    .form-check-label {
        text-transform: capitalize;
    }
</style>
@endsection


@section('content')
    <div class="container mt-2"id='container'>
        
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Employee Data  </h2>
                    @error('file')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('companies.create') }}"> Create Company</a>
                </div>
                <form action="{{ url('import-csv') }}" method="POST" name="importform" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input id="file" type="file" name="file"
                            style="
                            float: right;
                            margin: -15px 160px;">
                    </div>
                    <button class="btn btn-success" style="float: right; margin: -15px 7px;">Import CSV</button>
                    {{-- <a class="btn btn-primary" href="{{ route('importCSV') }}">Import CSV</a> --}}
                    <div class="dropdown" style="float: right;margin: -14px 2px 0 225px;">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            Export Data
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('generatePDF') }}">Export to PDF</a>
                            <a class="dropdown-item" href="{{ route('generateCSV') }}">Export to CSV</a>
                            {{-- <a class="dropdown-item" href="#">Link 3</a> --}}
                        </div>
                    </div>
                </form>


            </div>

        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }} </p>
            </div>
        @endif

        <input type="text" id="search" class="form-control" placeholder="Search by DBQuery.....">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    {{-- <th width="50px"><input type="checkbox" id="master"></th> --}}
                    <th>S.No</th>
                    <th>Company Name</th>
                    <th>Company Email</th>
                    <th>Company Address</th>
                    <th>File/image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tbody" class="reload">
            </tbody>
        </table>
        <input id="myInput" type="text" class="form-control" placeholder="Search by JQuery.....">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="50px"><input type="checkbox" id="master"></th>
                    <th>S.No</th>
                    <th>Company Name</th>
                    <th>Company Email</th>
                    <th>Company Address</th>
                    <th>File/image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="myTable" class="reload">
                @foreach ($companies as $company)
                    <tr id='{{ $company->id }}'>
                        <td><input type="checkbox" class="sub_chk" data-id="{{ $company->id }}"></td>
                        <td>{{ $loop->index + $companies->firstItem() }}</td>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->email }}</td>
                        <td>{{ $company->address }}</td>
                        <td><img src="/image/{{ $company->image }}" width="100px"></td>
                        <td>
                            @php
                                $prodID = Crypt::encrypt($company->id);
                            @endphp
                            <a class="btn btn-primary" href="{{ route('companies.edit', $prodID) }}">Edit</a>
                            <button type="buttom" class="btn btn-danger delete"
                                id="{{ $company->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $companies->links() }}
        <button class="btn btn-primary delete_all" data-url="{{ url('myproductsDeleteAll') }}">Delete All Selected</button>
        <button type="buttom" class="btn btn-primary" id="showjson">ShowJSONdata</button>
        <div>
            <table class="table table-bordered table-hover" id="showdata">
                <thead>
                    <tr>
                        <th>userId</th>
                        <th>Id</th>
                        <th>title</th>
                        <th>body</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                        $url = 'https://jsonplaceholder.typicode.com/posts';
                        $json = json_decode(file_get_contents($url), true);
                    @endphp
                    @foreach ($json as $jsondata)
                        <tr>
                            <td>{{ $jsondata['userId'] }}</td>
                            <td>{{ $jsondata['id'] }}</td>
                            <td>{{ $jsondata['title'] }}</td>
                            <td>{{ $jsondata['body'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- @php
            $i = 1;
            // Get the current URL without the query string...
            echo url()->current();
            
            // Get the current URL including the query string...
            echo url()->full();
            
            // Get the full URL for the previous request...
            echo url()->previous();
            echo Auth::user()->email;
        @endphp --}}
    
    
     @endsection 