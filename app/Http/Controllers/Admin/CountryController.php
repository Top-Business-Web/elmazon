<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCountry;
use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CountryController extends Controller
{
    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $countries = Country::get();
            return Datatables::of($countries)
                ->addColumn('action', function ($countries) {
                    return '
                            <button type="button" data-id="' . $countries->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $countries->id . '" data-title="' . $countries->name_en . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.countries.index');
        }
    }
    // Index End

    // Create Start
    public function create()
    {
        return view('admin.countries.parts.create');
    }
    // Create End

    // Store Start

    public function store(StoreCountry $request)
    {
        $inputs = $request->all();

        if (Country::create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Store End


    // Edit Start
    public function edit(Country $country)
    {

        return view('admin.countries.parts.edit', compact('country'));
    }
    // Edit End

    // Update Start

    public function update(StoreCountry $request, Country $country)
    {
        if ($country->update($request->all())) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Edit End

    // Destroy Start

    public function destroy(Request $request)
    {
        $countries = Country::where('id', $request->id)->firstOrFail();
        $countries->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    // Destroy End
}
