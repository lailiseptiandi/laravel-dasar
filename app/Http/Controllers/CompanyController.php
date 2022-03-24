<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::simplePaginate(5);

        return view('company.index', compact('companies'));
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
    public function store(CompanyRequest $request)
    {
        $request->all();
        $logo = $request->file('logo');
        $logo->storeAs('public/company', $logo->hashName());
        $companies = Company::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'logo' => $logo->hashName(),
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
        if (empty($request->file('logo'))) {
            $companies = Company::find($id);
            $companies->update(
                [
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                ]
            );
        } else {
            $companies = Company::find($id);
            $logo = $request->file('logo');
            $logo->storeAs('public/company', $logo->hashName());
            $companies->update(
                [
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'logo' => $logo->hashName()
                ]
            );
        }
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
        Company::find($id)->delete();
        return redirect()->back();
    }

    public function export_pdf(Request $request)
    {
        $id = $request->input('id_company');
        $employees = Employee::with('Company')->where('company_id', $id)->get();
        $pdf = PDF::loadView('employee.pdf-company->employee', ['employees' => $employees]);
        return $pdf->download();
    }
}
