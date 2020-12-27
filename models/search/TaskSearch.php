<?php
declare(strict_types=1);

namespace app\models\search;

use app\models\Task;
use yii\data\ActiveDataProvider;

class TaskSearch extends Task
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            ['title', 'string'],
            ['title', 'trim'],
            ['title', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params): ActiveDataProvider
    {
        $query = Task::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->load($params) || !$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

}