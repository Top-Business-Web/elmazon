<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestPhoneCommunication;
use App\Models\PhoneCommunication;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PhoneCommunicationController extends Controller
{
    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $Phone_communications = PhoneCommunication::get();
            return Datatables::of($Phone_communications)
                ->addColumn('action', function ($Phone_communications) {
                    return '
                            <button type="button" data-id="' . $Phone_communications->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $Phone_communications->id . '" data-title="' . $Phone_communications->phone . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.phone_communications.index');
        }
    }
    // Index End

    // Create Start

    public function create()
    {
        return view('admin.phone_communications.parts.create');
    }

    // Create End

    // Store Start

    public function store(RequestPhoneCommunication $request)
    {
        $inputs = $request->all();
        if(PhoneCommunication::create($inputs)){
            return response()->json(['status' => 200]);
        }
        else
        {
            return response()->json(['status' => 405]);
        }
    }

    // Store End

    // Edit Start

    public function edit(PhoneCommunication $phoneCommunication)
    {
        return view('admin.phone_communications.parts.edit', compact('phoneCommunication'));
    }

    // Edit End

    // Update Start

    public function update(RequestPhoneCommunication $request, PhoneCommunication $phoneCommunication)
    {
        if($phoneCommunication->update($request->all())){
            return response()->json(['status' => 200]);
        }
        else
        {
            return response()->json(['status' => 405]);
        }
    }

    // Update End

    // Destroy Start

    public function destroy(Request $request)
    {
        $phoneCommunication = PhoneCommunication::where('id', $request->id)->firstOrFail();
        $phoneCommunication->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Destroy End
}
