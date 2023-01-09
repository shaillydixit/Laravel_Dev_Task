<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Pagging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArtistController extends Controller
{
    public function index()
    {
        $data = Artist::where('status', '=', '0')->first();
        return view('backend.Artist', compact('data'));
    }

    public function addArtist(Request $request)
    {
        $data = array(
            'name'       => $request->name,
            'user_id'    => Auth::user()->id,
        );
        $data['status']           = '0';
        $data['created_at']     = date('Y-m-d H:i:s');
        $data['updated_at']      = date('Y-m-d H:i:s');
        $insertid =   DB::table('artists')->insertGetId($data);
        if ($insertid) {
            $row['res'] = '1';
        } else {
            $row['res'] = 0;
        }
        echo json_encode($row);
    }

    public function fetchArtist(Request $request)
    {
        $where = '';
        $aColumns = array('id', 'name', 'mst.status', 'mst.created_at');
        $isWhere = array("mst.status != '2'" . $where);
        $table = "artists as mst";
        $isJOIN = array();
        $hOrder = "mst.id desc";
        $sqlReturn = Pagging::get_datatables($aColumns, $table, $hOrder, $isJOIN, $isWhere, $request);
        $appData = array();
        $no = $request->iDisplayStart + 1;
        foreach ($sqlReturn['data'] as $row) {
            $row_data = array();
            $row_data[] = $no;
            $row_data[] = $row->name;
            $row_data[] =  '<div class="dropdown">
								<button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
									<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
								</button>
								<div class="dropdown-menu dropdown-menu-end">
									<a class="dropdown-item" href="javascript:;"  onclick="edit_artist(' . $row->id . ')">
										<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 me-50"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
									<span>Edit</span>
									</a>
									<a class="dropdown-item" href="javascript:;"  onclick="delete_artist(' . $row->id . ')">
										<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash me-50"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
									<span>Delete</span>
									</a>
								</div>
								</div> ';

            $appData[] = $row_data;
            $no++;
        }
        $totalrecord = Pagging::count_all($aColumns, $table, $hOrder, $isJOIN, $isWhere, '');
        $numrecord = $sqlReturn['data'];
        $output = array(
            "sEcho" => intval($request->sEcho),
            "iTotalRecords" =>  $numrecord,
            "iTotalDisplayRecords" => $totalrecord,
            "aaData" => $appData
        );
        echo json_encode($output);
    }

    public function editArtist(Request $request)
    {
        $artists = DB::table('artists')->where('id', '=', $request->id)->first();
        return json_encode($artists);
    }

    public function updateArtist(Request $request)
    {
        $edit_id = $request->edit_id;
        $row = array();
        if (!empty($edit_id)) {
            $data = array(
                'name'       => $request->edit_name,
                'user_id'    => Auth::user()->id,
            );

            $data['status']      = '0';
            $data['updated_at'] = date('Y-m-d H:i:s');
            $updateid =    DB::table('artists')
                ->where('id', $edit_id)
                ->update($data);
            if ($updateid) {
                $row['res'] = '3';
            } else {
                $row['res'] = 0;
            }
        }
        echo json_encode($row);
    }

    public function deleteArtist(Request $request)
    {
        $data = array(
            "status" => '2'
        );
        $affected = DB::table('artists')
            ->where('id', $request->id)
            ->update($data);
        $row = array();
        if ($affected) {
            $row['res'] = 1;
        } else {
            $row['res'] = 0;
        }
        return json_encode($row);
    }
}
