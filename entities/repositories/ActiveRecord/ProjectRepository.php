<?php

namespace app\entities\repositories\ActiveRecord;

use app\entities\models\Project;
use app\entities\models\UserProject;
use app\entities\repositories\ProjectRepositoryInterface;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
    /**
     * @var UserProject
     */
    private $userProjectModel;

    /**
     * ProjectRepository constructor.
     *
     * @param Project $model
     * @param UserProject $userProject
     */
    public function __construct(Project $model, UserProject $userProject)
    {
        parent::__construct($model);

        $this->userProjectModel = $userProject;
    }

    /**
     * @inheritdoc
     */
    public function findProjectsByUser(int $userId)
    {
        return $this->model
            ->find()
            ->leftJoin(
                $this->userProjectModel->tableName(),
                sprintf('%s.id=%s.project_id', $this->model->tableName(), $this->userProjectModel->tableName())
            )
            ->where(['user_id' => $userId])
            ->all();
    }
}