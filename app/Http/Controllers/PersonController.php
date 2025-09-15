// database/migrations/{timestamp}_create_people_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();           // Primary key (auto-increment)
            $table->string('name'); // Name column
            $table->integer('age'); // Age column
            $table->text('bio');    // Bio column
            $table->timestamps();   // Created at and updated at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('people');
    }
}
