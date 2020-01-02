<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Tank;
use App\User;
use Validator;
use Auth;
use App\Http\Resources\TankResource as TankResource;

class TanksController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        //$user = User::findOrFail($user);
        $tanks = Tank::where('user_id', $userId)->get();
        //$tanks_count = App\Tank::where('user_id', $user->id)->count();
        //$tanks = Tank::all();
        return $this->sendResponse(TankResource::collection($tanks), Auth::user());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store (Request $request)
    {
        $input = $request->all();

        $tank = Tank::create($input);

        return $this->sendResponse($tank->toArray(), 'Tank created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tank = Tank::find($id);


        if (is_null($tank)) {
            return $this->sendError('Tank not found.');
        }


        return $this->sendResponse($tank->toArray(), 'Tank retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tank $tank)
    {
        $input = $request->all();

        $tank->name = $input['name'];
        $tank->capacity = $input['capacity'];
        $tank->number = $input['number'];
        $tank->status = $input['status'];
        $tank->description = $input['description'];
        $tank->shrimp_id = $input['shrimp_id'];
        $tank->started_at = $input['started_at'];
        $tank->save();

        return $this->sendResponse($tank->toArray(), 'Tank updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tank $tank)
    {
        $tank->delete();


        return $this->sendResponse($tank->toArray(), 'Tank deleted successfully.');
    }
}
