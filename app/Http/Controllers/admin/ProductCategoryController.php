<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductCategoryRequest;
use App\Models\ProductCategory;
use Carbon\Carbon;
use DataTables;

class ProductCategoryController extends Controller {
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = ProductCategory::orderBy('id', 'desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $return = '<div class="btn-group">

                        <a href="' . route('admin.product_category.edit', ['id' => base64_encode($data->id)]) . '" class="btn btn-default btn-xs">
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

                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.product_category.index');
    }

    public function create(Request $request) {
        return view('admin.product_category.create');
    }

    public function insert(ProductCategoryRequest $request) {
        if ($request->ajax()) {
            return true;
        }

        $data = [
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'created_by' => Auth::id(),
            'updated_at' => Carbon::now(),
        ];
        $insert = ProductCategory::insert($data);
        if ($insert) {
            return redirect()->route('admin.product_category.index')->with('success', 'Record inserted successfully');
        } else {
            return redirect()->route('product_category.index')->with('error', 'Faild to insert record!');
        }
    }

    public function edit(Request $request, $id = '') {
        if (isset($id) && $id != '' && $id != null) {
            $id = base64_decode($id);
        } else {
            return redirect()->route('admin.product_category.index')->with('error', 'Something went wrong');
        }

        $data = ProductCategory::find($id);
        if ($data) {
            return view('admin.product_category.edit')->with(['data' => $data]);
        } else {
            return redirect()->back()->with(['error' => 'No data found!']);
        }
    }

    public function update(Request $request) {
        if ($request->ajax()) {
            return true;
        }

        if ($request->has('id')) {
            $data = [
                'name' => $request->name,
                'updated_by' => Auth::id(),
                'updated_at' => Carbon::now(),
            ];
            $insert = ProductCategory::where('id', $request->id)->update($data);
            if ($insert) {
                return redirect()->route('admin.product_category.index')->with('success', 'Record inserted successfully');
            } else {
                return redirect()->route('admin.product_category.index')->with('error', 'Faild to insert record!');
            }
        } else {
            return redirect()->route('admin.product_category.index')->with('error', 'Somthing went wrong!');
        }
    }

    public function change_status(Request $request) {
        if (!$request->ajax()) {
            exit('No direct script access allowed');
        }

        if (!empty($request->all())) {
            $id = base64_decode($request->id);
            $status = $request->status;

            $data = ProductCategory::where(['id' => $id])->first();

            if (!empty($data)) {
                if ($status == 'delete') {
                    $process = ProductCategory::where(['id' => $id])->delete();
                } else {
                    $process = ProductCategory::where(['id' => $id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);
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
