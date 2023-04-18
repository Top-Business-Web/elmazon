<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVideoResource;
use App\Http\Requests\UpdateVideoResource;
use App\Models\Term;
use App\Models\Season;
use App\Models\VideoResource;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VideoResourceController extends Controller
{
    use PhotoTrait;

    // Index Start
    public function index(request $request)
    {
        $video_resource_list = VideoResource::select('*');
        $terms = Term::all();
        $seasons = Season::all();
        if ($request->ajax()) {
            if ($request->has('term_id') && $request->term_id != '') {
                $term = $request->get('term_id');
                $video_resource_list->where('term_id', $term);
            }
            $video_resource = $video_resource_list->get();
            return Datatables::of($video_resource)
                ->addColumn('action', function ($video_resource) {
                    return '
                            <button type="button" data-id="' . $video_resource->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $video_resource->id . '" data-title="' . $video_resource->name_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>

                       ';
                })
                ->editColumn('image', function ($video_resource) {
                    return '<img style="width:60px;border-radius:30px" onclick="window.open(this.src)" src="' . asset('videos_resources/images/' . $video_resource->image) . '"/>';
                })
                ->editColumn('background_color', function ($video_resource) {
                    return '<input type="color" class="form-control" name="background_color"
                           value="' . $video_resource->background_color . '" disabled>';
                })
                ->editColumn('video_link', function ($video_resource) {
                    if ($video_resource->video_link)
                        return '<a href="' . asset($video_resource->video_link) . '">
                                لينك الفيديو
                            </a>';
                })
                ->editColumn('pdf_file', function ($video_resource) {
                    if ($video_resource->pdf_file)
                        return '<a href="' . asset($video_resource->pdf_file) . '">
                                لينك الملف الورقي
                            </a>';
                })
                ->filter(function ($video_resource) use ($request) {
                    if ($request->get('season_id')) {
                        $video_resource->where('season_id', $request->get('season_id'))->get();
                    }
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.video_resource.index', compact('terms', 'seasons'));
        }
    }

    // Index End

    public function videoResourceSort(Request $request)
    {
        $season = $request->season_id;
        $video_resources = Term::where('season_id', $season)->get();

        $output = '<option value="">اختر الترم</option>';

        foreach ($video_resources as $video_resource) {
            $output .= '<option value="' . $video_resource->id . '">' . $video_resource->name_ar . ' </option>';
        }
        if ($video_resource->count() > 0) {
            return $output;
        } else {
            return '<option value="">لا يوجد ترمات</option>';
        }

    }


    // Create Start

    public function create()
    {
        $data['seasons'] = Season::all();
        $data['terms'] = Term::all();
        return view('admin.video_resource.parts.create', compact('data'));
    }
    // Create End

    // Store Start

    public function store(StoreVideoResource $request)
    {
        $inputs = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();

            $file->move('videos_resources/images', $filename);
            $inputs['image'] = $filename;
        }

        if ($request->type == 'video') {
            $inputs['video_link'] = $this->saveImage($request->video_link, 'videos_resources/videos', 'photo');
        } else {
            $inputs['pdf_file'] = $this->saveImage($request->pdf_file, 'videos_resources/pdf', 'photo');
        }
        if (VideoResource::create($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Store End


    // Edit Start

    public function edit(VideoResource $videoResource)
    {
        $data['seasons'] = Season::all();
        $data['terms'] = Term::all();
        return view('admin.video_resource.parts.edit', compact('videoResource', 'data'));
    }


    // Edit End

    // Update Start

    public function update(UpdateVideoResource $request, VideoResource $videoResource)
    {

        if ($image = $request->hasFile('image')) {

            $name = time() . rand(1,3000) .  $request->file('image')->getClientOriginalName();
            $image->move('videos_resources/images/',$name);
            $request->image = $name;
        }

        if ($request->type == 'video') {
            if ($videoLink = $request->hasFile('video_link')) {
                $videoName = time() . rand(1,3000) .  $request->file('video_link')->getClientOriginalName();
                $request->file('video_link')->move('videos_resources/videos/',$videoName);
                $request->video_link = $videoName;
            }
        }

        if ($request->type == 'pdf') {
            if ($pdfFile = $request->hasFile('pdf_file')) {
                $pdfName = time() . rand(1,3000) .  $request->file('pdf_file')->getClientOriginalName();
                $request->file('pdf_file')->move('videos_resources/pdf/',$pdfName);
                $request->pdf_file = $pdfName;
            }
        }


        $success = $videoResource->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'background_color' => $request->background_color,
            'type' => $request->type,
            'image' => $request->hasFile('image') != null ? $name :  $videoResource->image,
            'season_id' => $request->season_id,
            'video_link' => $request->video_link,
            'pdf_file' => $request->pdf_file,
            'term_id' => $request->term_id,
        ]);

        if ($success) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    // Update End

    // Destroy Start

    public function destroy(Request $request)
    {
        $terms = VideoResource::where('id', $request->id)->firstOrFail();
        $terms->delete();
        return response()->json(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }


    // Destroy End
}
