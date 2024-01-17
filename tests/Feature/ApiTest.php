<?php

namespace Tests\Feature;

use App\Models\Adapters\ResultListDataConverter;
use App\Models\Member;
use Tests\TestCase;

class ApiTest extends TestCase
{
    const API_PATH = '/api/results/';

    public function test_api_response_status()
    {
        $response = $this->get(self::API_PATH);

        $response->assertStatus(200);
    }

    public function test_get_top_results()
    {
        $response = $this->get(self::API_PATH);

        $response->assertJsonStructure([
            'data' => [
                'top' => [
                    '*' => [
                        'email',
                        'place',
                        'milliseconds',
                    ],
                ],
            ],
        ]);
    }

    public function test_get_results_for_email()
    {
        $userWithResults = Member::has('results')->with('results')->first();

        if ($userWithResults) {
            $converter = new ResultListDataConverter();
            $response = $this->get(self::API_PATH . $userWithResults->email);
            $response->assertStatus(200);
            $response->assertJson([
                'data' => [
                    'self' => [
                        'email' => $converter->halfEmailHide($userWithResults->email),
                    ],
                ],
            ]);
        } else {
            $this->assertTrue(false, 'No user with results found.');
        }
    }

    public function test_get_results_for_invalid_email_format()
    {
        $invalidEmail = 'invalid-email-format';
        $response = $this->get(self::API_PATH . $invalidEmail);
        $response->assertStatus(404);
    }

    public function test_save_result()
    {
        $user = Member::factory()->create();
        $milliseconds = rand(1, 10000);
        $data = [
            'email' => $user->email,
            'milliseconds' => $milliseconds,
        ];

        $response = $this->post(self::API_PATH . 'save', $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('members', [
            'email' => $user->email,
        ]);

        $this->assertDatabaseHas('results', [
            'member_id' => $user->id,
            'milliseconds' => $milliseconds,
        ]);
    }

    public function test_required_milliseconds_for_save_result()
    {
        $response = $this->post(self::API_PATH . 'save', ['email' => 'test@example.com']);
        $response->assertStatus(400);
    }

    public function test_optional_email_for_save_result()
    {
        $milliseconds = rand(1, 10000);
        $response = $this->post(self::API_PATH . 'save', ['milliseconds' => $milliseconds]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('results', [
            'member_id' => null,
            'milliseconds' => $milliseconds,
        ]);
    }
}
