<?php

namespace App\Http\Interfaces;

use App\Http\Requests\ReportApiRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface ReportRepositoryInterface{


    public function studentAddReport(ReportApiRequest $request):JsonResponse;

}