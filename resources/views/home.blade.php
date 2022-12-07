@extends('dashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @php
        // $s = str_getcsv(file_get_contents('https://www.sample-videos.com/csv/Sample-Spreadsheet-10-rows.csv'));
        
        $data = file_get_contents('https://www.sample-videos.com/csv/Sample-Spreadsheet-10-rows.csv');
        $rows = explode("\n", $data);
        $s = [];
        foreach ($rows as $row) {
            $s[] = str_getcsv($row);
        }
        dump($s);
        
        $file = 'https://www.sample-videos.com/csv/Sample-Spreadsheet-10-rows.csv';
        
        $fileData = fopen($file, 'r');
        while (($line = fgetcsv($fileData)) !== false) {
            $s[] = $line;
        }
       
        dump($s);
        
        // $f = fopen($file, 'r');
        
        // for ($i = 1; ($line = fgetcsv($f)); $i++) {
        //     if ($i === 2) {
        //         // fclose($f);
        //         dd($line);
        //     }
        // }
        
        $a = array_filter($s, function ($i) {
            return $i['0'] == '10';
        });
        dump($a);
        $array = [['name' => 'John', 'age' => 45], ['name' => 'Haley', 'age' => 42], ['name' => 'Ally', 'age' => 8], ['name' => 'Meylyn', 'age' => 5], ['name' => 'Nicholas', 'age' => 1]];
        $result = array_filter($array, function ($value) {
            return $value['age'] > 18;
        });
        dump($result);
    @endphp --}}
@endsection
