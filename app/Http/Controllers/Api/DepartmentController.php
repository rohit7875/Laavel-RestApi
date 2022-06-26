<?php

namespace App\Http\Controllers\Api;

use App\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Exception;

class DepartmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = new Department();
            if (isset($request->name)) {
                $query = $query->where('name', 'like', "%$request->name%");
            }

            $department= $query->with('company')->latest()->paginate(5);
            return $this->sendResponse($department->toArray(), 'Department List Retrieve Successfully');
        } catch (\Exception $e) {
            $this->logExpection("getAllDepartment", $e->getMessage());

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
                'name' => 'required',
                'company_id' =>'required|exists:companies,id',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error', $validator->errors());
            }

            Department::create([
                'name' => $request->name ? $request->name :NULL,
                'company_id' => $request->company_id
            ]);

            return $this->sendResponseWithNoData('Department Create Successfully');
        } catch (Exception $e) {
            $this->logExpection("Create Department", $e->getMessage());

            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {


            $department = Department::where('id', $id)->with('company')->first();

            if($department)
            {
                return $this->sendResponse($department, 'Department details retrieved Successfully');

            }
            else
            {
                return $this->sendResponseWithNoData('Department details Not Found');
            }



        } catch (Exception $e) {
            $this->logExpection("view Department", $e->getMessage());

            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'id'    =>'required',
                'company_id' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error', $validator->errors());
            }
            $department::where('id', $request->id)->update($request->all());
            return $this->sendResponseWithNoData('Department Update Successfully');
        } catch (Exception $e) {
            $this->logExpection("Department Update", $e->getMessage());

            return $this->sendError($this->error_msg);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department,$id)
    {
        try {

            $department::where('id', $id)->delete();
            return $this->sendResponseWithNoData('department Deleted Successfully');
        } catch (Exception $e) {
            $this->logExpection("department Deleted", $e->getMessage());

            return $this->sendError($this->error_msg);
        }
    }
}
