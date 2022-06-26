<?php

namespace App\Http\Controllers\Api;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Exception;

class CompanyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = new Company();
            if (isset($request->name)) {
                $query = $query->where('name', 'like', "%$request->name%");
            }

            $company= $query->latest()->paginate(5);
            return $this->sendResponse($company->toArray(), 'Company List Retrieve Successfully');
        } catch (\Exception $e) {
            $this->logExpection("getAllCompany", $e->getMessage());

            return $this->sendError($this->error_msg);
        }
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
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error', $validator->errors());
            }

            Company::create([
                'name' => $request->name ? $request->name : NULL,
            ]);

            return $this->sendResponseWithNoData('Company Create Successfully');
        } catch (Exception $e) {
            $this->logExpection("Create Company", $e->getMessage());

            return $this->sendError($this->error_msg);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {


            $company = Company::where('id', $id)->first();
            if($company)
            {
                return $this->sendResponse($company,'Company details retrieved Successfully');
            }
            else
            {
                return $this->sendResponseWithNoData('Company details Not Found');
            }



        } catch (Exception $e) {
            $this->logExpection("Create Company", $e->getMessage());

            return $this->sendError($this->error_msg);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {


        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'id'    =>'required'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error', $validator->errors());
            }
            $company::where('id', $request->id)->update($request->all());
            return $this->sendResponseWithNoData('Company Update Successfully');
        } catch (Exception $e) {
            $this->logExpection("Company Update", $e->getMessage());

            return $this->sendError($this->error_msg);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company,$id)
    {
        try {

            $company::where('id', $id)->delete();
            return $this->sendResponseWithNoData('Company Deleted Successfully');
        } catch (Exception $e) {
            $this->logExpection("Company Deleted", $e->getMessage());

            return $this->sendError($this->error_msg);
        }
    }
}
