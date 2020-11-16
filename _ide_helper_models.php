<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Answer
 *
 * @property int $id
 * @property int $question_id
 * @property string $body
 * @property int $ordering
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $dependentQuestions
 * @property-read int|null $dependent_questions_count
 * @property-read \App\Models\Question $question
 * @method static \Illuminate\Database\Eloquent\Builder|Answer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Answer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Answer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereOrdering($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereUpdatedAt($value)
 */
	class Answer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Question
 *
 * @property int $id
 * @property int $survey_id
 * @property string $title
 * @property string $type
 * @property int $required
 * @property int $has_other
 * @property int|null $dependent_question_id
 * @property int|null $dependent_answer_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Answer[] $answers
 * @property-read int|null $answers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Question[] $children
 * @property-read int|null $children_count
 * @property-read \App\Models\Answer|null $dependentAnswer
 * @property-read Question|null $dependentQuestion
 * @property-read \App\Models\Survey $survey
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereDependentAnswerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereDependentQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereHasOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUpdatedAt($value)
 */
	class Question extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ResponsesView
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ResponsesView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResponsesView newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResponsesView query()
 */
	class ResponsesView extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Submission
 *
 * @property int $id
 * @property int $survey_employee_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SurveyEmployee $surveyEmployee
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserAnswers[] $userAnswers
 * @property-read int|null $user_answers_count
 * @method static \Illuminate\Database\Eloquent\Builder|Submission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Submission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Submission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereSurveyEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereUpdatedAt($value)
 */
	class Submission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Survey
 *
 * @property int $id
 * @property string $uuid
 * @property string $title
 * @property string $description
 * @property string $type
 * @property string $publish_date
 * @property string|null $due_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $questions
 * @property-read int|null $questions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Survey full()
 * @method static \Illuminate\Database\Eloquent\Builder|Survey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Survey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Survey private()
 * @method static \Illuminate\Database\Eloquent\Builder|Survey public()
 * @method static \Illuminate\Database\Eloquent\Builder|Survey published()
 * @method static \Illuminate\Database\Eloquent\Builder|Survey query()
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereUuid($value)
 */
	class Survey extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SurveyEmployee
 *
 * @property int $id
 * @property int $survey_id
 * @property int $user_id
 * @property int $target
 * @property string|null $due_date
 * @property int|null $sub_target
 * @property string|null $sub_target_type
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Submission[] $submissions
 * @property-read int|null $submissions_count
 * @property-read \App\Models\Survey $survey
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyEmployee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyEmployee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyEmployee query()
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyEmployee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyEmployee whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyEmployee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyEmployee whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyEmployee whereSubTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyEmployee whereSubTargetType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyEmployee whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyEmployee whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyEmployee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyEmployee whereUserId($value)
 */
	class SurveyEmployee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SurveyUser
 *
 * @property int $id
 * @property int $survey_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Survey $survey
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserAnswers[] $userAnswers
 * @property-read int|null $user_answers_count
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyUser whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyUser withAll()
 */
	class SurveyUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserAnswers
 *
 * @property int $id
 * @property string $model_type
 * @property int $model_id
 * @property int $question_id
 * @property string $response
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $model
 * @property-read \App\Models\Question $question
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnswers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnswers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnswers query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnswers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnswers whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnswers whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnswers whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnswers whereResponse($value)
 */
	class UserAnswers extends \Eloquent {}
}

namespace App\Models\User{
/**
 * App\Models\User\Employee
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $phone_number
 * @property string|null $ip
 * @property string $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SurveyEmployee[] $surveys
 * @property-read int|null $surveys_count
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 */
	class Employee extends \Eloquent {}
}

namespace App\Models\User{
/**
 * App\Models\User\Profile
 *
 * @property int $id
 * @property string $gender
 * @property int $age
 * @property string $birth_date
 * @property string $address
 * @property string $nationality
 * @property string $marital_status
 * @property int $user_id
 * @property mixed|null $additional_info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User\Standard $user
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereAdditionalInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereMaritalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUserId($value)
 */
	class Profile extends \Eloquent {}
}

namespace App\Models\User{
/**
 * App\Models\User\Standard
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $phone_number
 * @property string|null $ip
 * @property string $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\User\Profile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Survey[] $surveys
 * @property-read int|null $surveys_count
 * @method static \Illuminate\Database\Eloquent\Builder|Standard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Standard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Standard query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Standard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Standard whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Standard whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Standard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Standard whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Standard whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Standard wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Standard wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Standard whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Standard whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Standard whereUpdatedAt($value)
 */
	class Standard extends \Eloquent {}
}

namespace App\Models\User{
/**
 * App\Models\User\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $phone_number
 * @property string|null $ip
 * @property string $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Tymon\JWTAuth\Contracts\JWTSubject {}
}

