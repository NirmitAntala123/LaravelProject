<!DOCTYPE html>
<html>
<head>
    <title>Company Data</title>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $date }}</p>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Company Name</th>
                    <th>Company Email</th>
                    <th>Company Address</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                    <th>image</th>

                    {{-- <th>File/image</th> --}}
                   
                </tr>
            </thead>
            <tbody id="myTable" class="reload">
                @foreach ($products as $company)
                    <tr>
                        <td>{{ $company->id }}</td>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->email }}</td>
                        <td>{{ $company->address }}</td>
                        <td>{{ $company->created_at }}</td>
                        <td>{{ $company->updated_at }}</td>
                        <td>{{ $company->image }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</body>
</html>
