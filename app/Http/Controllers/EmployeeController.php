<?php

namespace App\Http\Controllers;

use PDF;
use Svg\Tag\Rect;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Imports\EmployeeImport;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\EmployeeRequest;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        $employees = Employee::with('Company')->simplePaginate(5);
        // dd($employees);
        // dd($employees);
        return view('employee.index', compact('companies', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        $request->all();
        $employees = Employee::create([
            'company_id' => $request->input('company_id'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->all();
        $employees = Employee::find($id)->update([
            'company_id' => $request->input('company_id'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employee::find($id)->delete();
        return redirect()->back();
    }

    public function export_pdf()
    {
        // $employees = Employee::all();
        $employees = Employee::with('Company')->get();

        $pdf = PDF::loadView('employee.pdf-employee', ['employees' => $employees]);
        return $pdf->download('employee.pdf');
    }

    public function import_excel()
    {
        // $file_excel = $request->file('excel_file');
        // $file_excel->storeAs('public/import', $file_excel->getClientOriginalName());
        $employees = Excel::import(new EmployeeImport, request()->file('excel_file'));
        if (!$employees) {
            return redirect()->back();
        }

        return redirect()->back();
    }
}
