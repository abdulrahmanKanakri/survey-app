<?php

use App\Enums\MediaTypes;
use App\Enums\TimeUnits;
use App\Models\Question;
use App\Models\Survey;
use App\Models\SurveyUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('title');
            $table->longText('description');
            $table->enum('type', Survey::TYPES);
            $table->timestamp('publish_date')->useCurrent();
            $table->timestamp('due_date')->nullable();
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id');
            $table->string('title');
            $table->enum('type', Question::getTypesKeys());
            $table->tinyInteger('required')->default(0);
            $table->tinyInteger('has_other')->default(0);
            $table->foreignId('dependent_question_id')->nullable();
            $table->foreignId('dependent_answer_id')->nullable();
            $table->timestamps();
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id');
            $table->text('body');
            $table->unsignedBigInteger('ordering')->default(100);
            $table->timestamps();
        });

        Schema::create('survey_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id');
            $table->foreignId('user_id');
            $table->timestamps();
        });

        Schema::create('survey_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id');
            $table->foreignId('user_id');
            $table->integer('target');
            $table->timestamp('due_date')->nullable();
            $table->integer('sub_target')->nullable();
            $table->enum('sub_target_type', TimeUnits::getConstants())->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
        
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_employee_id')
                ->references('id')
                ->on('survey_employees')
                ->onDelete('cascade');
            $table->timestamps();
        });
        
        Schema::create('user_answers', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->foreignId('question_id');
            $table->text('response');
        });
        
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ext');
            $table->string('path');
            $table->enum('type', MediaTypes::getConstants());
        });

        $this->handleViews();
        $this->relations();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropViews();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('surveys');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('survey_user');
        Schema::dropIfExists('user_answers');
        Schema::dropIfExists('survey_employees');
        Schema::dropIfExists('submissions');
        Schema::dropIfExists('media');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function relations() {
        Schema::table('questions', function (Blueprint $table) {
            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');
            $table->foreign('dependent_question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('dependent_answer_id')->references('id')->on('answers')->onDelete('cascade');
        });

        Schema::table('answers', function (Blueprint $table) {
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });

        Schema::table('survey_user', function (Blueprint $table) {
            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('survey_employees', function (Blueprint $table) {
            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('user_answers', function (Blueprint $table) {
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }
    
    private function handleViews() {
        DB::statement('DROP VIEW IF EXISTS responses_view');
        DB::statement(
            'CREATE VIEW responses_view AS
            SELECT s_u.survey_id, s.title survey_title, s_u.user_id, 
            u.name username, u.ip user_ip_address,
            u_a.question_id, q.title question_title, u_a.response,
            q.dependent_question_id, q.dependent_answer_id
            FROM user_answers u_a
            INNER JOIN survey_user as s_u ON u_a.model_id = s_u.id
            INNER JOIN surveys as s ON s_u.survey_id = s.id
            INNER JOIN users as u ON s_u.user_id = u.id
            INNER JOIN questions as q ON u_a.question_id = q.id'
        );
    }

    private function dropViews() {
        DB::statement('DROP VIEW IF EXISTS responses_view');
    }
}
