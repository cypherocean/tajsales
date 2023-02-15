<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CounterRequest;
use App\Models\Counter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CounterController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Counter::orderBy('id', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $return = '<div class="btn-group">

                        <a href="' . route('admin.counter.edit', ['id' => base64_encode($data->id)]) . '" class="btn btn-default btn-xs">
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
        return view('admin.counter.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.counter.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function insert(CounterRequest $request) {
        if ($request->ajax()) {
            return true;
        }
 
        $data = [
            'name' => $request->name,
            'count_number' => $request->counter_number,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        DB::beginTransaction();
        try {
            $insert = Counter::insertGetId($data);
            if ($insert) {
                DB::commit();
                return redirect()->route('admin.counter.index')->with('success', 'Record inserted successfully');
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
     * @param  \App\Models\Counter  $counter
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id = '') {
        if (isset($id) && $id != '' && $id != null){

            $id = base64_decode($id);
        } else {
            return redirect()->route('admin.counter.index')->with('error', 'Something went wrong');
        }

        $data = Counter::where(['id' => $id])
            ->first();

        return view('admin.counter.edit')->with(['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Counter  $counter
     * @return \Illuminate\Http\Response
     */
    public function update(CounterRequest $request) {
        if ($request->ajax()) {
            return true;
        }

        $id = $request->id;

        $data = [
            'name' => $request->name,
            'count_number' => $request->counter_number,
            'updated_at' => date('Y-m-d H:i:s')
        ];
 

        DB::beginTransaction();
        try {
            $update = Counter::where(['id' => $id])->update($data);

            if ($update) {
               DB::commit();
                return redirect()->route('admin.counter.index')->with('success', 'Record updated successfully');
            } else {
                DB::rollback();
                return redirect()->back()->with('error', 'Failed to update record')->withInput();
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong, please try again later')->withInput();
        }
    }

    public function  change_status(Request $request) {
        if (!$request->ajax()) {
            exit('No direct script access allowed');
        }

        if (!empty($request->all())) {
            $id = base64_decode($request->id);
            $status = $request->status;

            $data = Counter::where(['id' => $id])->first();

            if (!empty($data)) {
                if ($status == 'delete') {
                    $process = Counter::where(['id' => $id])->delete();
                } else {
                    $process = Counter::where(['id' => $id])->update(['status' => $status]);
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
}
