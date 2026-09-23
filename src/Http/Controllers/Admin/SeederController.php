<?php

namespace NumbersNebula\NebulaCosmetics\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use NumbersNebula\NebulaCosmetics\Database\Seeders\CleoLabDataSeeder;

class SeederController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected CleoLabDataSeeder $seeder) {}

    /**
     * Run the Cleo's Lab demo data seeder and return a JSON status.
     */
    public function run(): JsonResponse
    {
        try {
            $message = $this->seeder->run();

            return response()->json([
                'success' => true,
                'message' => $message ?: trans('nc::app.configuration.seeder_success'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
