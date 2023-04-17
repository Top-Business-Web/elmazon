<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\ReportRepositoryInterface;
use App\Http\Requests\ReportApiRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportRepository extends ResponseApi implements ReportRepositoryInterface {


    public function studentAddReport(ReportApiRequest $request): JsonResponse
    {

        try {

            return self::returnResponseDataApi(null,"Success",200);

        }catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }
}