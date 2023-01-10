<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Mail\UserRegister;
use Illuminate\Support\Str;
use Auth, DB, Mail, Validator, File, DataTables;

class UserController extends Controller {
    /** index */
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = User::orderBy('id', 'desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $return = '<div class="btn-group">';


                    $return .=  '<a href="' . route('admin.user.view', ['id' => base64_encode($data->id)]) . '" class="btn btn-default btn-xs">
                                                <i class="fa fa-eye"></i>
                                            </a> &nbsp;';


                    $return .= '<a href="' . route('admin.user.edit', ['id' => base64_encode($data->id)]) . '" class="btn btn-default btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a> &nbsp;';


                    $return .= '<a href="javascript:;" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-bars"></i>
                                            </a> &nbsp;
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="javascript:;" onclick="change_status(this);" data-status="active" data-id="' . base64_encode($data->id) . '">Active</a></li>
                                                <li><a class="dropdown-item" href="javascript:;" onclick="change_status(this);" data-status="inactive" data-id="' . base64_encode($data->id) . '">Inactive</a></li>
                                                <li><a class="dropdown-item" href="javascript:;" onclick="change_status(this);" data-status="delete" data-id="' . base64_encode($data->id) . '">Delete</a></li>
                                            </ul>';

                    $return .= '</div>';

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

                ->editColumn('name', function ($data) {
                    $image = '<img src="' . URL('/uploads/users/user-icon.jpg') . '" alt="user-icon" class="rounded-circle" width="45" height="45">';

                    if ($data->photo != '' || $data->photo != null)
                        $image =  '<img src="' . URL('/uploads/users/') . "/" . $data->photo . '" alt="user-icon" class="rounded-circle" width="45" height="45">';

                    return '<div class="d-flex no-block align-items-center">
                                            <div class="mr-3">
                                                ' . $image . '
                                            </div>
                                            <div class="">
                                                <span class="">' . $data->name . '</span>
                                            </div>
                                        </div>';
                })
                ->rawColumns(['name',  'action', 'status'])
                ->make(true);
        }

        return view('admin.user.index');
    }
    /** index */

    /** create */
    public function create(Request $request) {
        return view('admin.user.create');
    }
    /** create */

    /** insert */
    public function insert(UserRequest $request) {
        if ($request->ajax()) {
            return true;
        }
        $password = 'Abcd1234?';

        if ($request->password != '' && $request->password != NULL)
            $password = $request->password;

        $data = [
            'name' => ucfirst($request->name),
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => 'active',
            'password' => bcrypt($password),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => auth()->user()->id
        ];

        if (!empty($request->file('photo'))) {
            $file = $request->file('photo');
            $filenameWithExtension = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameToStore = time() . "_" . $filename . '.' . $extension;

            $folder_to_upload = public_path() . '/uploads/users/';

            if (!\File::exists($folder_to_upload))
                \File::makeDirectory($folder_to_upload, 0777, true, true);

            $data['photo'] = $filenameToStore;
        } else {
            $data['photo'] = 'user-icon.jpg';
        }

        DB::beginTransaction();
        try {
            $user = User::create($data);

            if ($user) {
                if (!empty($request->file('photo')))
                    $file->move($folder_to_upload, $filenameToStore);

                DB::commit();
                return redirect()->route('admin.user')->with('success', 'Record inserted successfully');
            } else {
                DB::rollback();
                return redirect()->back()->with('error', 'Failed to insert record')->withInput();
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong, please try again later')->withInput();
        }
    }
    /** insert */

    /** edit */
    public function edit(Request $request, $id = '') {
        if (isset($id) && $id != '' && $id != null)
            $id = base64_decode($id);
        else
            return redirect()->route('user')->with('error', 'Something went wrong');

        $path = URL('/uploads/users') . '/';
        $data = User::select(
            'id',
            'name',
            'email',
            'phone',
            'password',
            DB::Raw("CASE
                                        WHEN " . 'photo' . " != '' THEN CONCAT(" . "'" . $path . "'" . ", " . 'photo' . ")
                                        ELSE CONCAT(" . "'" . $path . "'" . ", 'user-icon.jpg')
                                    END as photo")
        )
            ->where(['id' => $id])
            ->first();

        return view('admin.user.edit')->with(['data' => $data]);
    }
    /** edit */

    /** update */
    public function update(UserRequest $request) {
        if ($request->ajax()) {
            return true;
        }

        $id = $request->id;
        $exst_rec = User::where(['id' => $id])->first();

        $data = [
            'name' => ucfirst($request->name),
            'email' => $request->email,
            'phone' => $request->phone,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => auth()->user()->id
        ];

        if ($request->password != '' && $request->password != NULL)
            $data['password'] = bcrypt($request->password);

        if (!empty($request->file('photo'))) {
            $file = $request->file('photo');
            $filenameWithExtension = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameToStore = time() . "_" . $filename . '.' . $extension;

            $folder_to_upload = public_path() . '/uploads/users/';

            if (!\File::exists($folder_to_upload))
                \File::makeDirectory($folder_to_upload, 0777, true, true);

            $data['photo'] = $filenameToStore;
        } else {
            $data['photo'] = $exst_rec->photo;
        }

        DB::beginTransaction();
        try {
            $update = User::where(['id' => $id])->update($data);

            if ($update) {
                if (!empty($request->file('photo'))) {
                    $file->move($folder_to_upload, $filenameToStore);

                    $file_path = public_path() . '/uploads/users/' . $exst_rec->photo;

                    if (File::exists($file_path) && $file_path != '') {
                        if ($data->photo != 'user-icon.jpg') {
                            @unlink($file_path);
                        }
                    }
                }

                DB::commit();
                return redirect()->route('admin.user')->with('success', 'Record updated successfully');
            } else {
                DB::rollback();
                return redirect()->back()->with('error', 'Failed to update record')->withInput();
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong, please try again later')->withInput();
        }
    }
    /** update */

    /** view */
    public function view(Request $request, $id = '') {
        if (isset($id) && $id != '' && $id != null)
            $id = base64_decode($id);
        else
            return redirect()->route('user')->with('error', 'Something went wrong');

        $path = URL('/uploads/users') . '/';
        $data = User::select(
            'id',
            'name',
            'email',
            'phone',
            'password',
            DB::Raw("CASE
                                        WHEN " . 'photo' . " != '' THEN CONCAT(" . "'" . $path . "'" . ", " . 'photo' . ")
                                        ELSE CONCAT(" . "'" . $path . "'" . ", 'user-icon.jpg')
                                    END as photo")
        )
            ->where(['id' => $id])
            ->first();

        return view('admin.user.view')->with(['data' => $data]);
    }
    /** view */

    /** change-status */
    public function change_status(Request $request) {
        if (!$request->ajax()) {
            exit('No direct script access allowed');
        }

        if (!empty($request->all())) {
            $id = base64_decode($request->id);
            $status = $request->status;

            $data = User::where(['id' => $id])->first();

            if (!empty($data)) {
                if ($status == 'delete') {
                    $process = User::where(['id' => $id])->delete();

                    $file_path = public_path() . '/uploads/users/' . $data->photo;

                    if (File::exists($file_path) && $file_path != '') {
                        if ($data->photo != 'user-icon.jpg') {
                            @unlink($file_path);
                        }
                    }
                } else {
                    $process = User::where(['id' => $id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);
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
    /** change-status */

    /** remove-profile */
    public function profile_remove(Request $request) {
        if (!$request->ajax()) {
            exit('No direct script access allowed');
        }

        if (!empty($request->all())) {
            $id = base64_decode($request->id);
            $data = User::find($id);

            if ($data) {
                if ($data->photo != '') {
                    $file_path = public_path() . '/uploads/users/' . $data->photo;

                    if (File::exists($file_path) && $file_path != '') {
                        if ($data->photo != 'user-icon.jpg') {
                            @unlink($file_path);
                        }
                    }

                    $update = User::where(['id' => $id])->update(['photo' => '']);

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
    /** remove-profile */
}
