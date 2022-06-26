<?php

namespace App\Http\Controllers\Api;

use App\User_detail;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Exception;

class UserDetailController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $name=$request->name;
            $query = new User_detail();
            if (isset($request->phone_number)) {
                $query = $query->where('phone_number', 'like', "%$request->phone_number%");
            }
            $users_detail = $query->with('users')->latest()->paginate(5);
            return $this->sendResponse($users_detail->toArray(), 'User Details Retrieve Successfully');
        } catch (\Exception $e) {
            $this->logExpection("getAllUserDetails", $e->getMessage());

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
                'phone_number' => 'required|digits:10|unique:user_details,phone_number',
                'address' => 'required',
                'user_id' => 'required|exists:users,id',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error', $validator->errors());
            }

            User_detail::create([
                'phone_number' => $request->phone_number ? $request->phone_number : NULL,
                'address' => $request->address ? $request->address : NULL,
                'user_id' => $request->user_id
            ]);

            return $this->sendResponseWithNoData('User Details Create Successfully');
        } catch (Exception $e) {
            $this->logExpection("Create User Details", $e->getMessage());

            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User_detail  $user_detail
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {


            $user = User_detail::where('id', $id)->with('users')->first();

            if ($user) {
                return $this->sendResponse($user, 'User details retrieved Successfully');
            } else {
                return $this->sendResponseWithNoData('User details Not Found');
            }
        } catch (Exception $e) {
            $this->logExpection("view User Details", $e->getMessage());

            return $this->sendError($e->getMessage());
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User_detail  $user_detail
     * @return \Illuminate\Http\Response
     */
    public function edit(User_detail $user_detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User_detail  $user_detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User_detail $user_detail)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone_number' => 'required|digits:10',
                'address' => 'required',
                'user_id' => 'required|exists:users,id',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error', $validator->errors());
            }
            $user_detail::where('id', $request->id)->update($request->all());
            return $this->sendResponseWithNoData('User Details Update Successfully');
        } catch (Exception $e) {
            $this->logExpection("User  Details Update", $e->getMessage());

            return $this->sendError($this->error_msg);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User_detail  $user_detail
     * @return \Illuminate\Http\Response
     */


    public function destroy(User_detail $user_detail, $id)
    {
        try {

            $user_detail::where('id', $id)->delete();
            return $this->sendResponseWithNoData('User Details Deleted Successfully');
        } catch (Exception $e) {
            $this->logExpection("User Details Deleted", $e->getMessage());

            return $this->sendError($this->error_msg);
        }
    }
}
