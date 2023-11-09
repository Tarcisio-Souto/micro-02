<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEvaluation;
use App\Http\Resources\EvaluationResource;
use App\Models\Evaluation;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{


    private $evaluation;
    private $companyService;

    public function __construct(Evaluation $evaluation, CompanyService $companyService)
    {
        $this->evaluation = $evaluation;
        $this->companyService = $companyService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($company)
    {
        $evaluations = $this->evaluation->where('company', $company)->get();
        return EvaluationResource::collection($evaluations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEvaluation $request, $company)
    {
        $response = $this->companyService->getCompany($company);
        $status = $response->status();
        if ($status != 200)
        {
            return response()->json([
                'message' => 'Invalid Company'
            ], $status);
        }

        $evaluation = $this->evaluation->create($request->validated());
        return new EvaluationResource($evaluation);
    }

}
