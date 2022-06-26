<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Exception;

class userController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = new User();
            if (isset($request->name)) {
                $query = $query->where('name', 'like', "%$request->name%");
            }

            $users = $query->with('department')->latest()->paginate(5);
            return $this->sendResponse($users->toArray(), 'User List Retrieve Successfully');
        } catch (\Exception $e) {
            $this->logExpection("getAllUser", $e->getMessage());

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
                'dept_id' => 'required|exists:departments,id',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error', $validator->errors());
            }

            User::create([
                'name' => $request->name ? $request->name : NULL,
                'dept_id' => $request->dept_id
            ]);

            return $this->sendResponseWithNoData('User Create Successfully');
        } catch (Exception $e) {
            $this->logExpection("Create User", $e->getMessage());

            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {


            $user = User::where('id', $id)->with('department')->first();

            if ($user) {
                return $this->sendResponse($user, 'User details retrieved Successfully');
            } else {
                return $this->sendResponseWithNoData('User details Not Found');
            }
        } catch (Exception $e) {
            $this->logExpection("view User", $e->getMessage());

            return $this->sendError($e->getMessage());
        }
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
    public function update(Request $request, User $user)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'id'    => 'required',
                'dept_id' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error', $validator->errors());
            }
            $user::where('id', $request->id)->update($request->all());
            return $this->sendResponseWithNoData('User Update Successfully');
        } catch (Exception $e) {
            $this->logExpection("User Update", $e->getMessage());

            return $this->sendError($this->error_msg);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, $id)
    {
        try {

            $user::where('id', $id)->delete();
            return $this->sendResponseWithNoData('User Deleted Successfully');
        } catch (Exception $e) {
            $this->logExpection("User Deleted", $e->getMessage());

            return $this->sendError($this->error_msg);
        }
    }
}
