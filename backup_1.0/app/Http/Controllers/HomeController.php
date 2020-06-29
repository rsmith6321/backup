<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $list = DB::table('provinces')
        ->orderBy('PROVINCE_NAME','asc')
        ->get();
        return view('home')->with('list',$list);
    }
    

    function fetchSite(Request $request){
        
        $id = $request->get('select');
        $query = DB::table('provinces')
        ->join('site','provinces.PROVINCE_ID','=','site.PROVINCE_ID')
        ->select('site.sit_id','site.sit_name')
        ->where('provinces.PROVINCE_ID',$id)
        ->groupBy('site.sit_id','site.sit_name')
        //->groupBy('sit_id.id')
        ->get();
        $output='<option value="">เลือกสำนักงาน</option>';
        foreach ($query as $row) {
            $output.= '<option value="'.$row->sit_id.'">'.$row->sit_name.'</option>';
        }
        echo $output;
        //echo '<option>hello</option>';
    } 

    function fetchTypework(Request $request){
        
        $id = $request->get('select');
        $result = array();
        $query = DB::table('site')
        ->join('typework','site.sit_id','=','typework.sit_id')
        ->select('typework.tyw_name','typework.tyw_id')
        ->where('site.sit_id',$id)
        ->groupBy('typework.tyw_name','typework.tyw_id')
        ->get();
        $output='<option value="">เลือกประเภทงาน</option>';
        foreach ($query as $row) {
            $output.= '<option value="'.$row->tyw_id.'">'.$row->tyw_name.'</option>';
        }
        echo $output;
        
    }
}
