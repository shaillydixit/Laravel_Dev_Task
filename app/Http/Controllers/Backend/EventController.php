<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Pagging;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class EventController extends Controller
{
    public function index()
    {
        $venue = Venue::where('status', '=', '0')->get();
        $artist = Artist::where('status', '=', '0')->get();
        $genre = Genre::where('status', '=', '0')->get();
        return view('backend.event', compact('venue', 'artist', 'genre'));
    }

    public function addEvent(Request $request)
    {
        $data = array(
            'title'             => $request->title,
            'artist_id'         => $request->artist_id,
            'genre_id'          => $request->genre_id,
            'short_description' => $request->short_description,
            'amount'            => $request->amount,
            'date'              => $request->date,
            'venue_id'          => $request->venue_id,
            'user_id'           => Auth::user()->id,
        );
        $filename = 'event_image_' . rand(100, 9999) . '.' . $request->image->extension();
        $request->image->move('files/event', $filename);
        $data['image'] = $filename;

        $data['status']     = '0';
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $insertid =   DB::table('events')->insertGetId($data);
        if ($insertid) {
            $row['res'] = '1';
        } else {
            $row['res'] = 0;
        }
        echo json_encode($row);
    }

    public function fetchEvent(Request $request)
    {
        $where = '';
        $aColumns = array('mst.id', 'mst.title', 'artist.name as artist_name', 'genre.name as genre_name', 'mst.image', 'short_description', 'mst.amount', 'mst.date', 'venue.name as venue_name', 'mst.status', 'mst.created_at');
        $isWhere = array("mst.status != '2'" . $where);
        $table = "events as mst";
        $isJOIN = array(
            'left join venues as venue on venue.id = mst.venue_id',
            'left join artists as artist on artist.id = mst.artist_id',
            'left join genres as genre on genre.id = mst.genre_id',
        );
        $hOrder = "mst.id desc";
        $sqlReturn = Pagging::get_datatables($aColumns, $table, $hOrder, $isJOIN, $isWhere, $request);
        $appData = array();
        $no = $request->iDisplayStart + 1;
        foreach ($sqlReturn['data'] as $row) {
            $row_data = array();
            $row_data[] = $no;
            $row_data[] = $row->title;
            $row_data[] = $row->artist_name;
            $row_data[] = $row->genre_name;
            $row_data[] = '<img src="' . URL::to('/') . '/files/event' . '/' . $row->image . '" class="img-thumbnail" style="width: 80px; height: 80px;">';
            $row_data[] = $row->short_description;
            $row_data[] = $row->amount;
            $row_data[] = $row->date;
            $row_data[] = $row->venue_name;
            $row_data[] =  '<div class="dropdown">
								<button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
									<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
								</button>
								<div class="dropdown-menu dropdown-menu-end">
									<a class="dropdown-item" href="javascript:;"  onclick="edit_event(' . $row->id . ')">
										<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 me-50"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
									<span>Edit</span>
									</a>
									<a class="dropdown-item" href="javascript:;"  onclick="delete_event(' . $row->id . ')">
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

    public function editEvent(Request $request)
    {
        $event = DB::table('events')->where('id', '=', $request->id)->first();
        $event->image_path = URL::to('/') . '/files/event' . '/' . $event->image;
        return json_encode($event);
    }

    public function updateEvent(Request $request)
    {
        $edit_id = $request->edit_id;
        $row = array();
        if (!empty($edit_id)) {
            $data = array(
                'title'             => $request->edit_title,
                'artist_id'         => $request->edit_artist_id,
                'genre_id'          => $request->edit_genre_id,
                'short_description' => $request->edit_short_description,
                'amount'            => $request->edit_amount,
                'date'              => $request->edit_date,
                'venue_id'          => $request->edit_venue_id,
                'user_id'           => Auth::user()->id,
            );
            if (!empty($request->edit_image)) {
                if (File::exists('files/event' . $request->edit_image_name)) {
                    unlink('files/event/' . $request->edit_image_name);
                }
                $filename = 'event_image_' . rand(100, 9999) . '.' . $request->edit_image->extension();
                $request->edit_image->move('files/event', $filename);
                $data['image'] = $filename;
            }

            $data['status']      = '0';
            $data['updated_at'] = date('Y-m-d H:i:s');
            $updateid =    DB::table('events')
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

    public function deleteEvent(Request $request)
    {
        $data = array(
            "status" => '2'
        );
        $affected = DB::table('events')
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
