<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use PDF;
use Excel;
use App\Exports\ExportUsers;
use App\Imports\ImportUsers;
use App\Events\Logcompany;
use App\Models\Admin;
class CompanyCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
          
                if ($request->ajax()) 
                {
                   
                    $output = "";
                    $products = DB::table('companies')->where('name', 'LIKE', '%' . $request->search . "%")
                    ->orwhere('id', 'LIKE', '%' . $request->search . "%")
                    ->orwhere('email', 'LIKE', '%' . $request->search . "%")
                    ->orwhere('address', 'LIKE', '%' . $request->search . "%")->get();
                    // dd($products);
                    if ($products) {
                        foreach ($products as $key => $product) {
                            $prodID = Crypt::encrypt($product->id);
                            $output .= '<tr id=' . $product->id .'>' .
                            '<td>' . $product->id . '</td>' .
                            '<td>' . $product->name . '</td>' .
                            '<td>' . $product->email . '</td>' .
                            '<td>' . $product->address . '</td>' .
                            '<td>' ."<img src=\"/image/$product->image\"  alt=\"Image\"width=\"100px\">". '</td>' .
                            '<td>' ." <a class=\"btn btn-primary\" href=\"/companies/$prodID/edit\">Edit</a><button type=\"button\" class=\"btn btn-danger delete\"
                            id=\"$product->id\">Delete</button>
                            ". '</td>' .
                                '</tr>';
                        }
                        return Response($output);
                    }
                }
                // if($request->ajax())
                // {
                //     // dd($request->ajax());
                //     $url = 'https://jsonplaceholder.typicode.com/posts';
                //     $json = json_decode(file_get_contents($url), true);
                //     $output1 = "";
                //     // dd($json);
                //     $output1 .=
                //             '<thead>'.
                //                 '<tr>'.
                //                     '<th>'."userId".'</th>'.
                //                     '<th>'."Id".'</th>'.
                //                     '<th>'."title".'</th>'.
                //                     '<th>'."body".'</th>'.
                //                 '</tr>'.
                //             '<thead>';
                //     if($json){
                //         // dd($json);
                //         foreach ($json as $jsondata) {
                //             // dd($jsondata);
                //             $output1 .=
                            
                //                 '<tr>'.
                //                     '<td>' . $jsondata["userId"] . '</td>' .
                //                     '<td>' .  $jsondata["id"] . '</td>' .
                //                     '<td>' .  $jsondata["title"] . '</td>' .
                //                     '<td>' .  $jsondata["body"] . '</td>' .
                //                 '</tr>'
                //            ;
                //         }
                //         // dd($jsondata);
                //         return Response($output1);
                //     }
                // }
                
           
            $data['companies'] = Company::orderBy('id', 'asc')->paginate(5);
            return view('companies.index', $data);
            // return view('dashboard');
        }
        return redirect("login")->withSuccess('registretion Successfully Done');

    }

    public function generatePDF(Request $request)
    {
        $data = [
            'title' => 'Company Data',
            'date' => date('m/d/Y')
        ];
        $products = Company::all();
        $pdf = PDF::loadView('myPDF', compact('products'),$data);
        return $pdf->download('CompanyData.pdf');
    }
    public function generateCSV()
    {
        return Excel::download(new ExportUsers, 'CompanyData.xlsx');
    }

    public function importCSV(Request $request) 
    {
        $request->validate([
            'file' => 'required|mimes:xlsx|max:2048',
        ]);
        Excel::import(new ImportUsers, request()->file('file'));
        return back();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:App\Models\Company,email|regex:/^.+@.+$/i',
            'address' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) {
                    if ($value === 'Nirmit') {
                        $fail('The ' . $attribute . ' is invalid.');
                    }
                },
            ],
        ]);
        // $messages = [
        //     'max'  => 'The :attribute a :other must match.',
        //     'same' => 'The :attribute and :other must match.',
        //     'size' => 'The :attribute must be exactly :size.',
        //     'between' => 'The :attribute value :input is not between :min - :max.',
        //     'in' => 'The :attribute must be one of the following types: :values',
        // ];
        // Validator::make($request->all(), [
        //     'name' => 'required|min:4|max:7',
        //     'email' => 'required',
        //     'address' => 'required'
        // ])->validate();

        $company = new Company;

        $company->name = $request->name;
        $company->email = $request->email;
        $company->address = $request->address;

        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $company['image'] = "$profileImage";
        }
        $company->save();
        event(new Logcompany($company));
        return redirect('/companies')->with('success', 'Company has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    // public function edit($companies)
    // {
    //     $company = Company::find($companies);

    //     return view('companies.edit')->with('data', $company);;
    // }
    public function edit(Request $request,$company)
    {
        $prodID = Crypt::decrypt($company);
        $company   = Company::find($prodID);
        return view('companies.edit', compact('company'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);

        $company = Company::find($id);
        $company->name = $request->name;
        $company->email = $request->email;
        $company->address = $request->address;
        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $company['image'] = "$profileImage";
        }
        $company->save();

        return redirect('/companies')
            ->with('success', 'Company Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        dump($company);
        return redirect()->route('companies.index')
            ->with('success', 'Company has been deleted successfully');
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        DB::table("companies")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Products Deleted successfully."]);
    }
}


  


