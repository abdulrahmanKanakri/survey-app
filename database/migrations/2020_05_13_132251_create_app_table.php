<?php

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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('title');
            $table->longText('description');
            $table->enum('type', Survey::TYPES);
            $table->timestamp('publish_date')->useCurrent();
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id');
            $table->string('title');
            $table->enum('type', Question::TYPES);
            $table->tinyInteger('required')->default(100);
            $table->foreignId('dependent_question_id')->nullable();
            $table->foreignId('dependent_answer_id')->nullable();
            $table->timestamps();
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id');
            $table->text('body');
            $table->unsignedBigInteger('ordering')->default(0);
            $table->timestamps();
        });

        Schema::create('survey_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id');
            $table->foreignId('user_id');
            $table->enum('status', SurveyUser::STATUSES)->default(SurveyUser::AVAILABLE);
            $table->timestamps();
        });

        Schema::create('user_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_user_id');
            $table->foreignId('question_id');
            $table->text('response');
        });

        DB::statement($this->responses_view());

        $this->relations();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        Schema::dropAllViews();
        Schema::dropIfExists('user_answers');
        Schema::dropIfExists('survey_user');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('surveys');

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

        Schema::table('user_answers', function (Blueprint $table) {
            $table->foreign('survey_user_id')->references('id')->on('survey_user')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    private function responses_view() {
        return 'CREATE VIEW responses_view AS
                SELECT s_u.survey_id, s.title survey_title, s_u.user_id, 
                u.name username, u.ip user_ip_address,
                u_a.question_id, q.title question_title, u_a.response,
                q.dependent_question_id, q.dependent_answer_id
                FROM user_answers u_a
                INNER JOIN survey_user as s_u ON survey_user_id = s_u.id
                INNER JOIN surveys as s ON s_u.survey_id = s.id
                INNER JOIN users as u ON s_u.user_id = u.id
                INNER JOIN questions as q ON u_a.question_id = q.id';
    }
}
