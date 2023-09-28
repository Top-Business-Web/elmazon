<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestPdfFileUpload;
use App\Models\Lesson;
use App\Models\PdfFileUpload;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PdfFileUploadController extends Controller
{
    // Index Start
    public function index(request $request)
    {
        if ($request->ajax()) {
            $pdfs = PdfFileUpload::get();
            return Datatables::of($pdfs)
                ->addColumn('action', function ($pdfs) {
                    return '
                            <button type="button" data-id="' . $pdfs->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $pdfs->id . '" data-title="' . $pdfs->pdf . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.pdf_file_uploads.index');
        }
    }
    // Index End

    // Create Start

    public function create()
    {
        $lessons = Lesson::get();
        return view('admin.pdf_file_uploads.parts.create', compact('lessons'));
    }

    // Create End

    // Store Start

    public function store(RequestPdfFileUpload $request)
    {
        $file = $request->file('pdf');
        $file->move('uploads/pdfs', $file->getClientOriginalName());
        $file_name = $file->getClientOriginalName();

        $insert = new PdfFileUpload();
        $insert->pdf = $file_name;
        $insert->lesson_id = $request->lesson_id;
        $insert->save();

        if ($insert->save() == true) {
            return response()->json(["status" => 200]);
        } else {
            return response()->json(["status" => 405]);
        }
    }

    // Store End

    //Edit Start

    public function edit(PdfFileUpload $pdf)
    {
        $lessons = Lesson::get();
        return view('admin.pdf_file_uploads.parts.edit', compact('pdf', 'lessons'));
    }

    // Edit End

    // Updated Start

    public function update(Request $request, PdfFileUpload $pdfFileUpload)
    {
        $pdfs = PdfFileUpload::findOrFail($request->id);
        if ($request->has('pdf')) {
            if (file_exists('uploads/pdfs/' . $pdfs->pdf)) {
                unlink('uploads/pdfs/' . $pdfs->pdf);
            }
            $file = $request->file('pdf');
            $file->move('uploads/pdfs', $file->getClientOriginalName());
            $file_name = $file->getClientOriginalName();
            $pdfs->pdf = $file_name;
        }

        $pdfs->lesson_id = $request->lesson_id;
        $pdfs->save();

        if ($pdfs->save() == true) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Update End

    // Destroy Start

    public function destroy(Request $request)
    {
        $pdfs = PdfFileUpload::where('id', $request->id)->firstOrFail();
        $pdfs->delete();
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }
    // Destroy End
}
