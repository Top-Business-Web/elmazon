<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\ReportRepositoryInterface;
use App\Http\Requests\ReportApiRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller{


    public $reportRepositoryInterface;

    public function __construct(ReportRepositoryInterface $reportRepositoryInterface)
    {

        $this->reportRepositoryInterface = $reportRepositoryInterface;
    }

    public function studentAddReport(ReportApiRequest $request):JsonResponse{

        return $this->reportRepositoryInterface->studentAddReport($request);
    }

}
