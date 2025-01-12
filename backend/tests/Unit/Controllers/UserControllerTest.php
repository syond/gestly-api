<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected const BASE_URI_V1 = '/api/v1/users';
    protected $dataProvider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dataProvider = [
            'name' => 'TESTE_MY_NAME_IS_TEST',
            'email' => 'test_mail@gmail.com',
            'birth_date' => '1982-08-15T03:00:00.000Z',
            'cpf' => '12345678911',
        ];
    }

    public function test_create_user()
    {
        $response = $this->postJson(self::BASE_URI_V1, $this->dataProvider);
        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'User created successfully.',
                'data' => [
                    'name' => 'TESTE_MY_NAME_IS_TEST',
                    'email' => 'test_mail@gmail.com',
                    'birth_date' => '1982-08-15T03:00:00.000Z',
                    'cpf' => '12345678911',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'cpf' => '12345678911',
        ]);
    }

    public function test_update_user()
    {
        $responsePost = $this->postJson(self::BASE_URI_V1, $this->dataProvider);
        $responsePostData = $responsePost->json('data');

        $dataProvider = [
            'email' => 'changing_email@gmail.com',
            'name' => 'TESTE_MY_NAME_IS_TEST',
            'birth_date' => '1982-08-15T03:00:00.000Z',
            'cpf' => '12345678911',
        ];

        $responsePut = $this->putJson(self::BASE_URI_V1 . '/' . $responsePostData['id'], $dataProvider);
        $responsePut->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'User updated successfully.',
                'data' => [
                    "id" => 1,
                    "name" => "TESTE_MY_NAME_IS_TEST",
                    "email" => "changing_email@gmail.com",
                    "birth_date" => "1982-08-15T03:00:00.000Z",
                    "cpf" => "12345678911"
                  ],
            ]);
        
        $this->assertDatabaseHas('users', [
            'email' => 'changing_email@gmail.com',
        ]);
    }

    public function test_show_user() {
        $responsePost = $this->postJson(self::BASE_URI_V1, $this->dataProvider);
        $responsePostData = $responsePost->json('data');

        $responseShow = $this->getJson(self::BASE_URI_V1 . '/' . $responsePostData['id']);

        $responseShow->assertStatus(200)
        ->assertJson($responseShow->json());
    }

    public function test_list_user() {
        User::factory()->count(3)->create();

        $response = $this->getJson(self::BASE_URI_V1);
        $response->assertStatus(200)
            ->assertJsonCount(3);
    }
}
