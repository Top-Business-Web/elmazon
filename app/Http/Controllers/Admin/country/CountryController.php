<?php

namespace App\Http\Controllers\Admin\country;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCountry;
use Illuminate\Http\Request;
use App\Models\Country;
use Yajra\DataTables\DataTables;

class CountryController extends Controller
{
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

    public function create()
    {
        return view('admin.countries.parts.create');
    }

    public function store(StoreCountry $request)
    {
        $inputs = $request->all();

        if (Country::create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    public function edit(Country $country)
    {
        return view('admin.countries.parts.edit', compact('country'));
    }

    public function update(StoreCountry $request, Country $country)
    {
        if ($country->update($request->all())) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    public function destroy(Request $request)
    {
        $countries = Country::where('id', $request->id)->first();
        $countries->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }
}
