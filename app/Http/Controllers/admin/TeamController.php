<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use File;

class TeamController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Team::orderBy('id', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $return = '<div class="btn-group">

                        <a href="' . route('admin.team.edit', ['id' => base64_encode($data->id)]) . '" class="btn btn-default btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a> &nbsp;

                        <a href="javascript:;" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-bars"></i>
                                        </a> &nbsp;
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:;" onclick="change_status(this);" data-status="active" data-id="' . base64_encode($data->id) . '">Active</a></li>
                                            <li><a class="dropdown-item" href="javascript:;" onclick="change_status(this);" data-status="inactive" data-id="' . base64_encode($data->id) . '">Inactive</a></li>
                                            <li><a class="dropdown-item" href="javascript:;" onclick="change_status(this);" data-status="delete" data-id="' . base64_encode($data->id) . '">Delete</a></li>
                                        </ul>

                    </div>';

                    return $return;
                })
                ->editColumn('image', function ($data) {
                    $image = '<img src="' . URL('/uploads/team/user-icon.jpg') . '" alt="user-icon" class="rounded-circle" width="45" height="45">';

                    if ($data->image != '' || $data->image != null)
                        $image =  '<img src="' . URL('/uploads/team/') . "/" . $data->image . '" alt="user-icon" class="rounded-circle" width="45" height="45">';

                    return '<div class="d-flex no-block align-items-center">
                                            
                                                ' . $image . '
                                        </div>';
                })
                ->editColumn('status', function ($data) {
                    if ($data->status == 'active') {
                        return '<span class="badge badge-pill badge-success">Active</span>';
                    } else if ($data->status == 'inactive') {
                        return '<span class="badge badge-pill badge-warning">Inactive</span>';
                    } else {
                        return '-';
                    }
                })

                ->rawColumns(['action', 'image', 'status'])
                ->make(true);
        }
        return view('admin.team.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.team.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTeamRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function insert(TeamRequest $request) {
        if ($request->ajax()) {
            return true;
        }
 
        $data = [
            'name' => $request->name,
            'facebook_url' => $request->facebook_url ?? null,
            'instagram_url' => $request->instagram_url ?? null,
            'twitter_url' => $request->twitter_url ?? null,
            'linked_in_url' => $request->linked_in_url ?? null,
            'created_at' => Carbon::now(),
            'created_by' => Auth::id(),
            'updated_at' => Carbon::now(),
        ];
        $data['image'] = 'defaultAvatar.png';
        if (!empty($request->file('photo'))) {
            $filenameWithExtension = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameToStore = time() . "_" . $filename . '.' . $extension;

            $folder_to_upload = public_path() . '/uploads/team/';

            if (!File::exists($folder_to_upload)) {
                File::makeDirectory($folder_to_upload, 0777, true, true);
            }

            $data['image'] = $filenameToStore;
        }

        DB::beginTransaction();
        try {
            $insert = Team::insertGetId($data);
            if ($insert) {
                if (!empty($request->file('photo'))) {
                    $request->file('photo')->move($folder_to_upload, $filenameToStore);
                }
                DB::commit();
                return redirect()->route('admin.team.index')->with('success', 'Record inserted successfully');
            } else {
                DB::rollback();
                return redirect()->back()->with('error', 'Failed to insert record')->withInput();
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong, please try again later')->withInput();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id = '') {
        if (isset($id) && $id != '' && $id != null){

            $id = base64_decode($id);
        } else {
            return redirect()->route('admin.team.index')->with('error', 'Something went wrong');
        }

        $path = URL('/uploads/team') . '/';
        $data = Team::select(
            'id',
            'name',
            'facebook_url',
            'linked_in_url',
            'instagram_url',
            'twitter_url',
            DB::Raw("CASE
                    WHEN " . 'image' . " != '' THEN CONCAT(" . "'" . $path . "'" . ", " . 'image' . ")
                    ELSE CONCAT(" . "'" . $path . "'" . ", 'user-icon.jpg')
                    END as image")
                )
            ->where(['id' => $id])
            ->first();

        return view('admin.team.edit')->with(['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTeamRequest  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(TeamRequest $request) {
        if ($request->ajax()) {
            return true;
        }

        $id = $request->id;
        $exst_rec = Team::where(['id' => $id])->first();

        $data = [
            'name' => $request->name,
            'facebook_url' => $request->facebook_url ?? null,
            'instagram_url' => $request->instagram_url ?? null,
            'twitter_url' => $request->twitter_url ?? null,
            'linked_in_url' => $request->linked_in_url ?? null,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => auth()->user()->id
        ];

        if (!empty($request->file('photo'))) {
            $filenameWithExtension = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameToStore = time() . "_" . $filename . '.' . $extension;

            $folder_to_upload = public_path() . '/uploads/team/';

            if (!File::exists($folder_to_upload))
                File::makeDirectory($folder_to_upload, 0777, true, true);

            $data['image'] = $filenameToStore;
        } else {
            $data['image'] = $exst_rec->image;
        }

        DB::beginTransaction();
        try {
            $update = Team::where(['id' => $id])->update($data);

            if ($update) {
                if (!empty($request->file('photo'))) {
                    $request->file('photo')->move($folder_to_upload, $filenameToStore);

                    $file_path = public_path() . '/uploads/team/' . $exst_rec->image;

                    if (File::exists($file_path) && $file_path != '') {
                        if ($data['image'] != 'user-icon.jpg') {
                            @unlink($file_path);
                        }
                    }
                }

                DB::commit();
                return redirect()->route('admin.team.index')->with('success', 'Record updated successfully');
            } else {
                DB::rollback();
                return redirect()->back()->with('error', 'Failed to update record')->withInput();
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong, please try again later')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function  change_status(Request $request) {
        if (!$request->ajax()) {
            exit('No direct script access allowed');
        }

        if (!empty($request->all())) {
            $id = base64_decode($request->id);
            $status = $request->status;

            $data = Team::where(['id' => $id])->first();

            if (!empty($data)) {
                if ($status == 'delete') {
                    $process = Team::where(['id' => $id])->delete();

                    $file_path = public_path() . '/uploads/team/' . $data->photo;

                    if (File::exists($file_path) && $file_path != '') {
                        if ($data->photo != 'user-icon.jpg') {
                            @unlink($file_path);
                        }
                    }
                } else {
                    $process = Team::where(['id' => $id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);
                }

                if ($process)
                    return response()->json(['code' => 200]);
                else
                    return response()->json(['code' => 201]);
            } else {
                return response()->json(['code' => 201]);
            }
        } else {
            return response()->json(['code' => 201]);
        }
    }

    public function image_remove(Request $request) {
        if (!$request->ajax()) {
            exit('No direct script access allowed');
        }

        if (!empty($request->all())) {
            $id = base64_decode($request->id);
            $data = Team::find($id);

            if ($data) {
                if ($data->image != '') {
                    $file_path = public_path() . '/uploads/team/' . $data->image;

                    if (File::exists($file_path) && $file_path != '') {
                        if ($data->image != 'user-icon.jpg') {
                            @unlink($file_path);
                        }
                    }

                    $update = Team::where(['id' => $id])->update(['image' => '']);

                    if ($update)
                        return response()->json(['code' => 200]);
                    else
                        return response()->json(['code' => 201]);
                } else {
                    return response()->json(['code' => 200]);
                }
            } else {
                return response()->json(['code' => 201]);
            }
        } else {
            return response()->json(['code' => 201]);
        }
    }
}
