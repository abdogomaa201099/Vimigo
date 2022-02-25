<?php

namespace App\Http\Controllers\RESTAPI;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
class UserResource extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userlist=User::paginate(4);
        return response()->json ($userlist,200);
    }

    /**
     * Store a newly created user in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $validated = $request->validated();
         $user = User::create($request->all());
         return response()->json($user, 201);
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(User::where('id', '=', $id)->count() > 0){
            $user= User::find($id);
            return response()->json($user, 200);
        }else{
            return response(['message' =>'Invalid Id'], 400);
        }
        
        
    }


    /**
     * Update the specified user in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        if(User::where('id', '=', $id)->count() > 0){
            $validated = $request->validated();
            $user= User::find($id);
            $user->update($request->all());
            return response()->json($user, 200);
        }else{
            return response(['message' =>'Invalid Id'], 400);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(User::where('id', '=', $id)->count() > 0){
            $user= User::find($id);
            $user->delete();
            return response(['message' =>'User Removed Successfully'], 200);
        }else{
            return response(['message' =>'Invalid Id'], 400);
        }
        
    }
}
