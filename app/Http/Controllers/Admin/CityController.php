<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Traits\AdminLogs;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CityController extends Controller
{

    use AdminLogs;
    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $cities = City::get();
            return Datatables::of($cities)
                ->addColumn('action', function ($cities) {
                    return '
                            <button type="button" data-id="' . $cities->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $cities->id . '" data-title="' . $cities->name_en . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.cities.index');
        }
    }
    // Index End

    // Create Start
    public function create()
    {
        return view('admin.cities.parts.create');
    }
    // Create End

    // Store Start

    public function store(Request $request)
    {
        $inputs = $request->all();

        if (City::create($inputs)) {
            $this->adminLog('تم اضافة دولة');
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Store End

     // Edit Start
     public function edit(City $city)
     {
         return view('admin.cities.parts.edit', compact('city'));
     }
     // Edit End

     // Update Start

     public function update(Request $request, City $city)
     {

         if ($city->update($request->all())) {
             $this->adminLog('تم تحديث الدولة');
             return response()->json(['status' => 200]);
         } else {
             return response()->json(['status' => 405]);
         }
     }

     // Edit End

     // Destroy Start

     public function destroy(Request $request)
     {
         $citites = City::where('id', $request->id)->firstOrFail();
         $citites->delete();
         $this->adminLog('تم حذف محافظة');
         return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
     }

     // Destroy End
}
