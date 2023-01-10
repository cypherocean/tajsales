<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Carbon\Carbon;
use DataTables;
use Faker\Provider\Image;
use File;

class ProductController extends Controller {
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Product::select('products.id' ,'products.title' ,DB::raw("SUBSTRING(products.product_description, 1, 50) AS product_description"),'products.status', 'product_categories.name AS category_name')
                        ->leftjoin('product_categories', 'products.product_category_id' ,'product_categories.id')
                        ->orderBy('id', 'desc')->get();
 

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $return = '<div class="btn-group">

                        <a href="' . route('admin.product.view', ['id' => base64_encode($data->id)]) . '" class="btn btn-default btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a> &nbsp;

                        <a href="' . route('admin.product.edit', ['id' => base64_encode($data->id)]) . '" class="btn btn-default btn-xs">
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

                ->rawColumns(['image', 'action', 'status'])
                ->make(true);
        }
        return view('admin.product.index');
    }

    public function create(Request $request) {
        $data = array();
        $categories = ProductCategory::where('status', 'active')->get(['id', 'name']);
        if ($categories->isNotEmpty()) {
            $data = $categories;
        }
        return view('admin.product.create')->with(['data' => $data]);
    }

    public function insert(ProductRequest $request) {
        if ($request->ajax()) {
            return true;
        }

        $data = [
            'product_category_id' => $request->category,
            'title' => $request->title,
            'product_description' => $request->product_description,
            'created_at' => Carbon::now(),
            'created_by' => Auth::id(),
            'updated_at' => Carbon::now(),
        ];

        DB::beginTransaction();
        try {
            $insert = Product::insertGetId($data);
            if ($insert) {
                if (!empty($request->file('photo'))) {
                    $crud = array();
                    foreach ($request->file('photo') as $imagefile) {
                        $file = $imagefile;
                        $filenameWithExtension = $imagefile->getClientOriginalName();
                        $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
                        $extension = $imagefile->getClientOriginalExtension();
                        $filenameToStore = time() . "_" . $filename . '.' . $extension;

                        $folder_to_upload = public_path() . '/uploads/product/';

                        if (!\File::exists($folder_to_upload)) {
                            \File::makeDirectory($folder_to_upload, 0777, true, true);
                        }

                        $crud['product_id'] = $insert;
                        $crud['image'] = $filenameToStore;
                        $crud['created_at'] = Carbon::now()->format("Y-m-d H:i:s");
                        $crud['created_by'] = Auth::id();
                        $crud['updated_at'] = Carbon::now()->format("Y-m-d H:i:s");
                        $crud['updated_by'] = Auth::id();

                        $file->move($folder_to_upload, $filenameToStore);
                        ProductImage::insertGetId($crud);
                    }
                    DB::commit();
                    return redirect()->route('admin.product.index')->with('success', 'Record inserted successfully');
                } else {
                    DB::commit();
                    return redirect()->route('admin.product.index')->with('success', 'Record inserted successfully');
                }
            } else {
                DB::rollback();
                return redirect()->back()->with('error', 'Failed to insert record')->withInput();
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong, please try again later')->withInput();
        }
    }

    public function edit(Request $request, $id = '') {
        if (isset($id) && $id != '' && $id != null) {
            $id = base64_decode($id);
        } else {
            return redirect()->route('admin.product.index')->with('error', 'Something went wrong');
        }
        $categories = array();
        $g_categories = ProductCategory::where('status', 'active')->get(['id', 'name']);
        if ($g_categories->isNotEmpty()) {
            $categories = $g_categories;
        }

        $data = Product::select('id', 'product_category_id', 'title', 'product_description')
            ->where(['id' => $id])
            ->first();
        $images = ProductImage::where(['product_id' => $id])->get();
        return view('admin.product.edit')->with(['data' => $data, 'categories' => $categories, 'images' => $images]);
    }

    public function update(Request $request) {
        if ($request->ajax()) {
            return true;
        }

        $id = $request->id;
        $exst_image_rec = ProductImage::where(['product_id' => $id])->get()->toArray();


        $data = [
            'product_category_id' => $request->category,
            'title' => $request->title,
            'product_description' => $request->product_description,
            'updated_by' => Auth::id(),
            'updated_at' => Carbon::now(),
        ];

        DB::beginTransaction();
        try {
            $update = Product::where(['id' => $id])->update($data);

            if ($update) {
                if (!empty($request->file('photo'))) {
                    if (!empty($exst_image_rec)) {
                        foreach ($exst_image_rec as $old_image) {
                            $file_path = public_path() . '/uploads/product/' . $old_image['image'];
                            if (File::exists($file_path) && $file_path != '') {
                                if ($old_image['image'] != 'noImage.jpg') {
                                    @unlink($file_path);
                                }
                            }
                        }
                    }
                    $crud = array();
                    ProductImage::where(['product_id' => $id])->delete();
                    foreach ($request->file('photo') as $imagefile) {
                        $file = $imagefile;
                        $filenameWithExtension = $imagefile->getClientOriginalName();
                        $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
                        $extension = $imagefile->getClientOriginalExtension();
                        $filenameToStore = time() . "_" . $filename . '.' . $extension;

                        $folder_to_upload = public_path() . '/uploads/product/';

                        if (!\File::exists($folder_to_upload)) {
                            \File::makeDirectory($folder_to_upload, 0777, true, true);
                        }

                        $crud['product_id'] = $id;
                        $crud['image'] = $filenameToStore;
                        $crud['created_at'] = Carbon::now()->format("Y-m-d H:i:s");
                        $crud['created_by'] = Auth::id();
                        $crud['updated_at'] = Carbon::now()->format("Y-m-d H:i:s");
                        $crud['updated_by'] = Auth::id();

                        $file->move($folder_to_upload, $filenameToStore);
                        ProductImage::insertGetId($crud);
                    }
                }
                DB::commit();
                return redirect()->route('admin.product.index')->with('success', 'Record updated successfully');
            } else {
                DB::rollback();
                return redirect()->back()->with('error', 'Failed to update record')->withInput();
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong, please try again later')->withInput();
        }
    }

    public function view(Request $request, $id = '') {
        if (isset($id) && $id != '' && $id != null) {
            $id = base64_decode($id);
        } else {
            return redirect()->route('product.index')->with('error', 'Something went wrong');
        }

        $categories = array();
        $g_categories = ProductCategory::where('status', 'active')->get(['id', 'name']);
        if ($g_categories->isNotEmpty()) {
            $categories = $g_categories;
        }
        $data = Product::select('id', 'product_category_id', 'title', 'product_description')
            ->where(['id' => $id])
            ->first();
        $images = ProductImage::where(['product_id' => $id])->get();
        return view('admin.product.view')->with(['data' => $data, 'images' => $images, 'categories' => $categories]);
    }

    public function change_status(Request $request) {
        if (!$request->ajax()) {
            exit('No direct script access allowed');
        }

        if (!empty($request->all())) {
            $id = base64_decode($request->id);
            $status = $request->status;

            $data = Product::where(['id' => $id])->first();

            if (!empty($data)) {
                if ($status == 'delete') {
                    $process = Product::where(['id' => $id])->delete();

                    $file_path = public_path() . '/uploads/product/' . $data->photo;

                    if (File::exists($file_path) && $file_path != '') {
                        if ($data->photo != 'user-icon.jpg') {
                            @unlink($file_path);
                        }
                    }
                } else {
                    $process = Product::where(['id' => $id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);
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
