<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, check if the units column exists, if not create it
        if (!Schema::hasColumn('subjects', 'units')) {
            Schema::table('subjects', function (Blueprint $table) {
                $table->integer('units')->default(3);
            });
        }
        
        // Update the units for specific subjects
        $subjectData = [
            'IT401' => 1,
            'IT402' => 1,
            'IT403' => 2,
        ];
        
        foreach ($subjectData as $code => $units) {
            DB::table('subjects')
                ->where('code', $code)
                ->update(['units' => $units]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse this migration
    }
}; 