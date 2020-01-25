<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Shrimp;
use App\Http\Resources\ShrimpResource as ShrimpResource;

class ShrimpsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shrimps = Shrimp::all();
        return $this->sendResponse(ShrimpResource::collection($shrimps), 'Shrimps retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shrimp = Shrimp::find($id);


        if (is_null($shrimp)) {
            return $this->sendError('Shrimp not found.');
        }


        return $this->sendResponse($shrimp->toArray(), 'Shrimp retrieved successfully.');
    }
}
