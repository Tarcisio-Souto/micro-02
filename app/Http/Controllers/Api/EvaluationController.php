<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEvaluation;
use App\Http\Resources\EvaluationResource;
use App\Http\Resources\EvalutionResource;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{


    private $evaluation;

    public function __construct(Evaluation $evaluation)
    {
        $this->evaluation = $evaluation;
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
        $evaluation = $this->evaluation->create($request->validated());
        return new EvaluationResource($evaluation);
    }

}
