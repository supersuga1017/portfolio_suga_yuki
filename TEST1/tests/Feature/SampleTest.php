<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SampleTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        // $response = $this->get('/');
        // $response->assertStatus(200);

        

        // NondeliveryControllerのaddメソッドにGETリクエストを送信
        // $response = $this->get(route('nondeliveries.add'));
        // $response = $this->get($this->add());
        $response = $this->get('2');

        // レスポンスの内容が '2' であることを確認
        $response->assertSeeText('2f');
    }

    public function add()
    {
        return '3fsfdsf';
    }
}
