<?php

namespace App\Http\Controllers\Api\Comment;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentReplayResource;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\CommentReplay;
use App\Models\VideoParts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller{


    public function videoAddComment(Request $request,$id){

        $video = VideoParts::where('id','=',$id)->first();
        if(!$video){

            return self::returnResponseDataApi(null,"هذا الفيديو غير موجود",404,404);
        }

        $rules = [
            'comment' => 'nullable',
            'type' => 'required|in:file,text,audio',
            'audio' => 'nullable',
            'image' => 'nullable|mimes:jpg,png,jpeg'
        ];
        $validator = Validator::make($request->all(), $rules, [
            'image.mimes' => 407,
            'type.in' => 408
        ]);

        if ($validator->fails()) {

            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [
                    407 => 'Failed,The image type must be an jpg or jpeg or png.',
                    408 => 'Failed,The type of comment must be an file or text or audio',

                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi( null,isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return self::returnResponseDataApi(null,$validator->errors()->first(),422);
        }

        if($image = $request->file('image')){
            $destinationPath = 'comments_upload_file/';
            $file = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $file);
            $request['image'] = "$file";

        }elseif( $audio = $request->file('audio')){
            $audioPath = 'comments_upload_file/';
            $audioUpload = date('YmdHis') . "." . $audio->getClientOriginalExtension();
            $audio->move($audioPath, $audioUpload);
            $request['audio'] = "$audioUpload";
        }else{
            $comment = $request->comment;
        }


        if($request->comment && $request->audio && $request->image){

            return self::returnResponseDataApi(null,"يجب كتابه كومنت او ارفاق صوره او رفع ملف صوتي",422);
        }

        $add_comment = Comment::create([

            'comment' => $comment ?? null,
            'audio' => $audioUpload ?? null,
            'image' => $file ?? null,
            'type' => $request->type,
            'video_part_id' => $id,
            'user_id' => Auth::guard('user-api')->id()
        ]);


        if(isset($add_comment)){
            return self::returnResponseDataApi(new CommentResource($add_comment),"تم التعليق بنجاح",200);

        }

    }

    public function commentAddReplay(Request $request,$id){

        $comment = Comment::where('id','=',$id)->first();
        if(!$comment){

            return self::returnResponseDataApi(null,"هذا التعليق غير موجود",404,404);
        }

        $rules = [
            'replay' => 'nullable',
            'type' => 'required|in:file,text,audio',
            'audio' => 'nullable',
            'image' => 'nullable|mimes:jpg,png,jpeg',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'image.mimes' => 407,
            'type.in' => 408
        ]);

        if ($validator->fails()) {

            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [
                    407 => 'Failed,The image type must be an jpg or jpeg or png.',
                    408 => 'Failed,The type of comment must be an file or text or audio',

                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi( null,isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return self::returnResponseDataApi(null,$validator->errors()->first(),422);
        }

        if($image = $request->file('image')){
            $destinationPath = 'comments_upload_file/';
            $file = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $file);
            $request['image'] = "$file";

        }elseif( $audio = $request->file('audio')){
            $audioPath = 'comments_upload_file/';
            $audioUpload = date('YmdHis') . "." . $audio->getClientOriginalExtension();
            $audio->move($audioPath, $audioUpload);
            $request['audio'] = "$audioUpload";
        }else{
            $replay = $request->replay;
        }


        if($request->replay && $request->audio && $request->image){

            return self::returnResponseDataApi(null,"يجب الرد علي التعليق بكومنت او ارفاق صوره او رفع ملف صوتي",422);
        }

        $comment_replay = CommentReplay::create([

            'comment' => $replay ?? null,
            'audio' => $audioUpload ?? null,
            'image' => $file ?? null,
            'type' => $request->type,
            'comment_id' => $id,
            'student_id' => Auth::guard('user-api')->id()
        ]);


        if(isset($comment_replay)){
            return self::returnResponseDataApi(new CommentReplayResource($comment_replay),"تم الرد علي التعليق بنجاح",200);

        }
    }

    public function updateComment(Request $request,$id){

        $comment = Comment::where('id','=',$id)->first();
        if(!$comment){

            return self::returnResponseDataApi(null,"هذا التعليق غير موجود",404,404);
        }

        $rules = [
            'comment' => 'nullable',
            'type' => 'required|in:file,text,audio',
            'audio' => 'nullable',
            'image' => 'nullable|mimes:jpg,png,jpeg'
        ];
        $validator = Validator::make($request->all(), $rules, [
            'image.mimes' => 407,
            'type.in' => 408
        ]);

        if ($validator->fails()) {

            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [
                    407 => 'Failed,The image type must be an jpg or jpeg or png.',
                    408 => 'Failed,The type of comment must be an file or text or audio',

                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi( null,isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return self::returnResponseDataApi(null,$validator->errors()->first(),422);
        }

        if($image = $request->file('image')){
            $destinationPath = 'comments_upload_file/';
            $file = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $file);
            $request['image'] = "$file";



        }elseif( $audio = $request->file('audio')){
            $audioPath = 'comments_upload_file/';
            $audioUpload = date('YmdHis') . "." . $audio->getClientOriginalExtension();
            $audio->move($audioPath, $audioUpload);
            $request['audio'] = "$audioUpload";


        }else{
            $comment_add = $request->comment;
        }


        if($request->comment && $request->audio && $request->image){
            return self::returnResponseDataApi(null,"يجب كتابه كومنت او ارفاق صوره او رفع ملف صوتي",422);
        }

        if ($comment->user_id == Auth::guard('user-api')->id()){
            $comment->update([

                'comment' => $comment_add ?? null,
                'audio' => $audioUpload ?? null,
                'image' => $file ?? null,
                'type' => $request->type,
            ]);

        }else{
            return self::returnResponseDataApi(null,"ليس لديك صلاحيه لتعديل هذا التعليق",403);
        }

        if(isset($comment)){
            return self::returnResponseDataApi(new CommentResource($comment),"تم تعديل التعليق بنجاح",200);
        }

    }

    public function deleteComment($id){

        $comment = Comment::where('id','=',$id)->first();
        if(!$comment){

            return self::returnResponseDataApi(null,"هذا التعليق غير موجود",404,404);
        }
        if ($comment->user_id == Auth::guard('user-api')->id()){
            $comment->delete();

        }else{
            return self::returnResponseDataApi(null,"ليس لديك صلاحيه لمسح هذا التعليق",403);
        }
            return self::returnResponseDataApi(null,"تم حذف التعليق بنجاح",200);

    }


    public function updateReplay(Request $request,$id){


        $replay = CommentReplay::where('id','=',$id)->first();
        if(!$replay){

            return self::returnResponseDataApi(null,"هذا الرد غير موجود",404,404);
        }

        $rules = [
            'comment' => 'nullable',
            'type' => 'required|in:file,text,audio',
            'audio' => 'nullable',
            'image' => 'nullable|mimes:jpg,png,jpeg'
        ];
        $validator = Validator::make($request->all(), $rules, [
            'image.mimes' => 407,
            'type.in' => 408
        ]);

        if ($validator->fails()) {

            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [
                    407 => 'Failed,The image type must be an jpg or jpeg or png.',
                    408 => 'Failed,The type of comment replay must be an file or text or audio',

                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi( null,isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return self::returnResponseDataApi(null,$validator->errors()->first(),422);
        }

        if($image = $request->file('image')){
            $destinationPath = 'comments_upload_file/';
            $file = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $file);
            $request['image'] = "$file";



        }elseif( $audio = $request->file('audio')){
            $audioPath = 'comments_upload_file/';
            $audioUpload = date('YmdHis') . "." . $audio->getClientOriginalExtension();
            $audio->move($audioPath, $audioUpload);
            $request['audio'] = "$audioUpload";


        }else{
            $comment_add = $request->comment;
        }


        if($request->comment && $request->audio && $request->image){
            return self::returnResponseDataApi(null,"يجب كتابه كومنت او ارفاق صوره او رفع ملف صوتي",422);
        }

        if ($replay->student_id == Auth::guard('user-api')->id()){
            $replay->update([

                'comment' => $comment_add ?? null,
                'audio' => $audioUpload ?? null,
                'image' => $file ?? null,
                'type' => $request->type,
            ]);

        }else{
            return self::returnResponseDataApi(null,"ليس لديك صلاحيه لتعديل هذا الرد",403);
        }

        if(isset($replay)){
            return self::returnResponseDataApi(new CommentReplayResource($replay),"تم تعديل الرد بنجاح",200);
        }
    }

    public function deleteReplay($id){

        $replay = CommentReplay::where('id','=',$id)->first();
        if(!$replay){
            return self::returnResponseDataApi(null,"هذا الرد غير موجود",404,404);
        }
        if ($replay->student_id == Auth::guard('user-api')->id()){
            $replay->delete();

        }else{
            return self::returnResponseDataApi(null,"ليس لديك صلاحيه لمسح هذا الرد",403);
        }

        return self::returnResponseDataApi(null,"تم حذف الرد بنجاح",200);

    }
}
