<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DaysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $Sclose = DB::table('siteclose')->select('scl_date')->get();
        $Sgenaral = DB::table('sitegenaraldate')->get();
        $hol = DB::table('holiday')->get();
        $obj = json_decode($hol, true);
        $time = time();
        for ($i = 0; $i < 90; $i++) {
            $time = strtotime("+1 day", $time);
            $date[$i]['title'] = 'เปิดจอง';
            $date[$i]['start'] = date("Y-m-d", $time);
            $date[$i]['color'] = '#77dd77';
            for ($j = 0; $j < count($hol); $j++) {

                if ($date[$i]['start'] == $obj[$j]['hol_date']) {

                    unset($date[$i]);
                    $date[$i]['title'] = $obj[$j]['hol_name'];
                    $date[$i]['start'] = $obj[$j]['hol_date'];
                    $date[$i]['color'] = '#ff6961';
                    break;
                }
            }
        }

        return response()->json($date);
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
    public function show($id)
    {
        return response()->json(['id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $username)
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
