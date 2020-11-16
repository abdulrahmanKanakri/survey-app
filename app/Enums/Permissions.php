<?php

namespace App\Enums;

abstract class Permissions extends BasicEnum
{
    // ADMINS
    const ADMIN_CREATE = 'admin-create';
    const ADMIN_EDIT = 'admin-edit';
    const ADMIN_DELETE = 'admin-delete';
    const ADMIN_LIST = 'admin-list';
    
    // USERS
    const USER_LIST = 'user-list';
    const USER_CREATE = 'user-create';
    const USER_EDIT = 'user-edit';
    const USER_DELETE = 'user-delete';

    // ROLES
    const ROLE_LIST = 'role-list';
    const ROLE_CREATE = 'role-create';
    const ROLE_EDIT = 'role-edit';
    const ROLE_DELETE = 'role-delete';

    // SURVEYS
    const SURVEY_LIST = 'survey-list';
    const SURVEY_SHOW = 'survey-show';
    const SURVEY_CREATE = 'survey-create';
    const SURVEY_EDIT = 'survey-edit';
    const SURVEY_DELETE = 'survey-delete';
    const SURVEY_EXPORT = 'survey-export';

    // QUESTIONS
    const QUESTION_LIST = 'question-list';
    const QUESTION_CREATE = 'question-create';
    const QUESTION_EDIT = 'question-edit';
    const QUESTION_DELETE = 'question-delete';

    // ANSWERS
    const ANSWER_LIST = 'answer-list';
    const ANSWER_CREATE = 'answer-create';
    const ANSWER_EDIT = 'answer-edit';
    const ANSWER_DELETE = 'answer-delete';

    // SURVEY_QUESTION
    const SURVEY_QUESTION_CREATE = 'survey-question-create';
    const SURVEY_QUESTION_EDIT = 'survey-question-edit';
    const SURVEY_QUESTION_DELETE = 'survey-question-delete';

    // RESPONSE
    const RESPONSE_LIST = 'response-list';
    const RESPONSE_SHOW = 'response-show';
    const RESPONSE_DELETE = 'response-delete';
    const RESPONSE_EXPORT = 'response-export';
}
