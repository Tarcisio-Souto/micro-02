<?php

namespace Tests\Feature\Api;

use App\Models\Evaluation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class EvaluationTest extends TestCase
{
    /**
     * Test Empty Response.
     *
     * @return void
     */
    public function test_get_evaluations_empty()
    {
        $response = $this->getJson('/evaluations/fake-company');
        
        $response->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    /**
     * Get All Evaluations Company.
     *
     * @return void
     */
    public function test_get_evaluations_company()
    {
        $company = (string) Str::uuid();
        $evaluations = Evaluation::factory()->count(7)->create([
            'company' => $company
        ]);


        $response = $this->getJson("/evaluations/{$company}");
        
        $response->assertStatus(200)
            ->assertJsonCount(7, 'data');
    }

    
    /**
     * Test Connection Micro 01 For Store Evaluation.
     *
     * @return void
     */
    public function test_error_store_evaluation()
    {
        $company = 'fake-company';

        $response = $this->postJson("/evaluations/{$company}", []);
        
        $response->assertStatus(422);
    }


    /**
     * Test Connection Micro 01 For Store Evaluation.
     *
     * @return void
     */
    public function test_store_evaluation()
    {
        $company = 'fake-company';

        $response = $this->postJson("/evaluations/{$company}", [
            'company' => (string) Str::uuid(),
            'comment' => 'New Comment',
            'stars' => 5
        ]);
        
        $response->assertStatus(404);
    }


}
