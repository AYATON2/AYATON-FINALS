<?php

// database/migrations/{timestamp}_create_people_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->text('bio');
            $table->timestamps();
            // Add is_archived column (0 for not archived, 1 for archived)
            $table->boolean('is_archived')->default(0);
            // Add archived_at column for timestamp when archived
            $table->timestamp('archived_at')->nullable();
            // Soft delete column
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('people');
    }
}
