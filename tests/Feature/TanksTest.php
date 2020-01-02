<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Carbon\Carbon;
use App\Tank;
class TanksTest extends TestCase
{
    /** @test */
    public function tank_can_be_added()
    {
        $this->post('/api/tanks', [
            'name' => 'test',
            'description' => 'test',
            'started_at' => '2019-12-12',
            'status' => 1,
            'user_id' => 1,
            'number' => 11,
            'shrimp_id' => 1,
            'capacity' => 20,
        ]);

        $this->assertEquals(200, $response->status());
    }
}
