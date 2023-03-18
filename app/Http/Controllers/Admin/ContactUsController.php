<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ContactUsController extends Controller
{
    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $contacts_us = ContactUs::get();
            return Datatables::of($contacts_us)
                ->addColumn('action', function ($contacts_us) {
                    return '
                            <button type="button" data-id="' . $contacts_us->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $contacts_us->id . '" data-title="' . $contacts_us->name_en . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.contact_us.index');
    }
    // Index End

    // Create Start

    public function create()
    {
        return view('admin.contact_us.parts.create');
    }
    // Create End

    // Store Start

    public function store(ContactUs $request)
    {
        $inputs = $request->all();

        if (ContactUs::create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Store Start

}
