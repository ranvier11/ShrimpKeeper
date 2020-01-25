<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Tank;
use App\Mesurement;
use App\Http\Resources\MesureResource as MesureResource;

class MesurementController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tankId)
    {
        $mesurements = Mesurement::where('tank_id', $tankId)->get();
        return $this->sendResponse(MesureResource::collection($mesurements), 'data restrived successfully');
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

        $mesurement = Mesurement::create($input);

        return $this->sendResponse($mesurement->toArray(), 'Mesurement created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mesurement = Mesurement::find($id);

        if (is_null($mesurement)) {
            return $this->sendError('Mesurement not found.');
        }
        return $this->sendResponse($tank->toArray(), 'Mesurement retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mesurement $mesurement)
    {
        $input = $request->all();

        $mesurement->tank_id = $input['tank_id'];
        $mesurement->tempC = $input['tempC'];
        $mesurement->ph = $input['ph'];
        $mesurement->kh = $input['kh'];
        $mesurement->gh = $input['gh'];
        $mesurement->no3 = $input['no3'];
        $mesurement->ppm = $input['ppm'];
        $mesurement->us = $input['us'];
        $mesurement->description = $input['description'];
        $tank->save();

        return $this->sendResponse($mesurement->toArray(), 'Mesurement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mesurement $mesurement)
    {
        $mesurement->delete();

        return $this->sendResponse($mesurement->toArray(), 'Mesurement deleted successfully.');
    }
}
