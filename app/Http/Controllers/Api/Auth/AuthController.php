<?php

namespace App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Controller;
use App\Http\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\Request;


class AuthController extends Controller
{


    public $authRepositoryInterface;

    public function __construct(AuthRepositoryInterface $authRepositoryInterface){

        $this->authRepositoryInterface = $authRepositoryInterface;
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {

        return $this->authRepositoryInterface->login($request);
    }

    public function addSuggest(Request $request): \Illuminate\Http\JsonResponse
    {

        return $this->authRepositoryInterface->addSuggest($request);
    }


    public function allNotifications(): \Illuminate\Http\JsonResponse
    {

        return $this->authRepositoryInterface->allNotifications();
    }

    public function communication(): \Illuminate\Http\JsonResponse
    {
        return $this->authRepositoryInterface->communication();
    }

    public function getProfile(Request $request): \Illuminate\Http\JsonResponse
    {

        return $this->authRepositoryInterface->getProfile($request);
    }


    public function paper_sheet_exam(Request $request,$id)
    {

        return $this->authRepositoryInterface->paper_sheet_exam($request,$id);
    }

    public function paper_sheet_exam_show(): \Illuminate\Http\JsonResponse
    {

        return $this->authRepositoryInterface->paper_sheet_exam_show();
    }


    public function updateProfile(Request $request): \Illuminate\Http\JsonResponse
    {

        return $this->authRepositoryInterface->updateProfile($request);
    }

    public function home_page(): \Illuminate\Http\JsonResponse
    {

        return $this->authRepositoryInterface->home_page();
    }

    public function startYourJourney(Request $request): \Illuminate\Http\JsonResponse{

        return $this->authRepositoryInterface->startYourJourney($request);
    }

    public function add_device_token(Request $request)
    {

        return $this->authRepositoryInterface->add_device_token($request);
    }

    public function add_notification(Request $request): \Illuminate\Http\JsonResponse
    {

        return $this->authRepositoryInterface->add_notification($request);
    }

    public function user_add_screenshot(): \Illuminate\Http\JsonResponse
    {

        return $this->authRepositoryInterface->user_add_screenshot();

    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {

        return $this->authRepositoryInterface->logout($request);
    }
}
