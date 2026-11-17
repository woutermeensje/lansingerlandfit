<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $trainingId = DB::table('trainings')->where('slug', 'xco-walking')->value('id');

        if ($trainingId === null) {
            return;
        }

        DB::table('lessons')->where('training_id', $trainingId)->where('day', 5)->delete();

        DB::table('trainings')->where('id', $trainingId)
            ->where('seo_title', 'Xco Walking in Berkel en Rodenrijs en Nootdorp')
            ->update([
                'seo_title' => 'XCO Walking in Berkel en Rodenrijs',
                'updated_at' => now(),
            ]);
    }

    /**
     * Herstel de vervallen les niet bij een rollback; het rooster wordt via de admin beheerd.
     */
    public function down(): void {}
};
