<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\ModalResource;
use Illuminate\Support\Facades\DB;

class ModalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $typework = DB::table('typework')->get();
        return response()->json($typework);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($typework)
    {
        $typework_comment = DB::table('typework')
        ->select('typework.tyw_comment')
        ->where('typework.tyw_id',$typework)
        ->get();
        // $obj = json_decode($typework_comment, true);
        // $results = DB::select('select $typework_comment from typework where $typework_id = typework', ['typework' => $typework]);
        // return new ModalResource($results); 
        return response()->json($typework_comment);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}