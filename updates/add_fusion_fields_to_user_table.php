<?php
namespace Jhendess\FusionAuth\Updates;

use October\Rain\Database\Updates\Migration;
use October\Rain\Support\Facades\Schema;

class AddFusionFieldsToUserTable extends Migration {
    public function up() {
        Schema::table('users', function ($table) {
            $table->string('fusion_algo', 40)->nullable();
            $table->string('fusion_salt', 40)->nullable();
        });
    }

    public function down() {
        Schema::table('users', function ($table) {
            $table->dropColumn('fusion_algo');
            $table->dropColumn('fusion_salt');
        });
    }
}
