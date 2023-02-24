<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Models\Country;
use App\Models\Season;
use App\Models\User;
use App\Traits\PhotoTrait;
use Buglinjo\LaravelWebp\Exceptions\CwebpShellExecutionFailed;
use Buglinjo\LaravelWebp\Exceptions\DriverIsNotSupportedException;
use Buglinjo\LaravelWebp\Exceptions\ImageMimeNotSupportedException;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    use PhotoTrait;
    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $users = User::get();
            return Datatables::of($users)
                ->addColumn('action', function ($users) {
                    return '
                            <button type="button" data-id="' . $users->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $users->id . '" data-title="' . $users->name . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.users.index');
        }
    }
    // Index End

    // Create Start
    public function create()
    {
        $data['seasons'] = Season::get();
        $data['countries'] = Country::get();
        return view('admin.users.parts.create')->with($data);
    }
    // Create End

    // Store Start

    public function store(StoreUser $request)
    {
        $inputs = $request->all();
        $inputs['user_status'] = 'active';

        if($request->has('image')){
            $inputs['image'] = $this->saveImage($request->image,'assets/uploads/students','photo');
        }

        if (User::create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Store End


    // Edit Start
    public function edit(User $user)
    {
        $data['seasons'] = Season::get();
        $data['countries'] = Country::get();
        return view('admin.users.parts.edit', compact('user'))->with($data);
    }
    // Edit End

    // Update Start

    /**
     * @throws CwebpShellExecutionFailed
     * @throws ImageMimeNotSupportedException
     * @throws DriverIsNotSupportedException
     */
    public function update(StoreUser $request, User $user)
    {

        $inputs = $request->except('id');

        if ($request->has('image')) {
            if (file_exists($user->image)) {
                unlink($user->image);
            }
            $inputs['image'] = $this->saveImage($request->image, 'assets/uploads/students','photo');
        }

        if ($user->update($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }

    }

    // Edit End

    // Destroy Start

    public function destroy(Request $request)
    {
        $user = User::where('id', $request->id)->firstOrFail();
        $user->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Destroy End
}
