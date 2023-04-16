<?php

namespace App\Http\Interfaces;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
interface AuthRepositoryInterface{


    public function login(Request $request): \Illuminate\Http\JsonResponse;

    public function addSuggest(Request $request): \Illuminate\Http\JsonResponse;

    public function allNotifications(): \Illuminate\Http\JsonResponse;

    public function communication(): \Illuminate\Http\JsonResponse;

    public function getProfile(Request $request): \Illuminate\Http\JsonResponse;


    public function paper_sheet_exam(Request $request, $id);
    public function paper_sheet_exam_show(): \Illuminate\Http\JsonResponse;
    public function updateProfile(Request $request): \Illuminate\Http\JsonResponse;

    public function home_page(): \Illuminate\Http\JsonResponse;
    public function startYourJourney(Request $request):\Illuminate\Http\JsonResponse;
    public function add_device_token(Request $request);
    public function add_notification(Request $request): \Illuminate\Http\JsonResponse;
    public function user_add_screenshot(): \Illuminate\Http\JsonResponse;
    public function logout(Request $request): \Illuminate\Http\JsonResponse;
}