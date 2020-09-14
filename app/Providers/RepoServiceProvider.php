<?php

namespace App\Providers;

use App\Repositories\Answer\AnswerRepositoryImpl;
use App\Repositories\Answer\IAnswerRepository;
use App\Repositories\Question\IQuestionRepository;
use App\Repositories\Question\QuestionRepositoryImpl;
use App\Repositories\Role\IRoleRepository;
use App\Repositories\Role\RoleRepositoryImpl;
use App\Repositories\Survey\ISurveyRepository;
use App\Repositories\Survey\SurveyRepositoryImpl;
use App\Repositories\User\IUserRepository;
use App\Repositories\User\UserRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IUserRepository::class, UserRepositoryImpl::class);
        $this->app->bind(IRoleRepository::class, RoleRepositoryImpl::class);
        $this->app->bind(ISurveyRepository::class, SurveyRepositoryImpl::class);
        $this->app->bind(IQuestionRepository::class, QuestionRepositoryImpl::class);
        $this->app->bind(IAnswerRepository::class, AnswerRepositoryImpl::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
