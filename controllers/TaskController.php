<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\search\TaskSearch;
use yii\web\NotFoundHttpException;
use app\service\notification\Notification;
use app\service\notification\entity\Message;

/**
 * Class TaskController
 * @package app\controllers
 */
class TaskController extends Controller
{
    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionIndex()
    {
        $this->view->title = Yii::t('app', 'title task index page');
        Yii::$app->params['breadcrumbs'][] = $this->view->title;

        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $grid = \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'created_at',
                    'format' => 'datetime',
                ],
                'title',
                'description',
                [
                    'attribute' => 'is_finished',
                    'label' => Yii::t('app', 'task is finished'),
                    'format' => 'boolean',
                ],
                [
                    'class' => \yii\grid\ActionColumn::class,
                    'template' => '{update} {delete}',
                    'header' => Yii::t('app', 'action'),
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return \yii\helpers\Html::a(Yii::t('app', 'edit'), [$url]) . '&nbsp;';
                        },
                        'delete' => function ($url, $model) {
                            return \yii\helpers\Html::a(Yii::t('app', 'remove'), [$url], [
                                'data' => [
                                    'confirm' => Yii::t('app', 'remove'),
                                    'method' => 'post',
                                ],
                            ]);
                        },
                    ],
                ],
            ],
        ]);

        return $this->render('index.twig',
            [
                'grid' => $grid,
            ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id = 0)
    {
        $model = ($id > 0) ? $this->findModel($id) : new Task();
        $isNewRecord = $model->isNewRecord;

        $this->view->title = $isNewRecord ? Yii::t('app', 'title page add') : Yii::t('app', 'title page edit {id}', ['id' => $model->id]);
        Yii::$app->params['breadcrumbs'][] = $this->view->title;

        if (Yii::$app->request->isPost) {

            if ($model->load(Yii::$app->request->post())) {

                if ($model->save()) {

                    if ($isNewRecord) {
                        $message = new Message();
                        $message->title = Yii::t('app', 'title message add');
                        $message->text = Yii::t('app', 'text message new {id} {title}', ['id' => $model->id, 'title' => $model->title]);

                        (new Notification())->send($message);
                    }

                    Yii::$app->session->setFlash('success', Yii::t('app', 'task saved'));
                    return $this->redirect(['index']);
                }

                Yii::$app->session->setFlash('error', Yii::t('app', 'error on save'));

            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'exception {error}', ['error' => $model->getFirstError()]));
            }
        }

        return $this->render('update.twig', [
            'model' => $model
        ]);
    }

    /**
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete(int $id)
    {
        $task = $this->findModel($id);

        $message = new Message();
        $message->title = Yii::t('app', 'title message deleted');
        $message->text = Yii::t('app', 'text message deleted {id} {title}', ['id' => $task->id, 'title' => $task->title]);

        if ($task->delete() !== false) {
            (new Notification())->send($message);
            Yii::$app->session->setFlash('success', Yii::t('app', 'task deleted'));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'error on delete'));
        }

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return Task|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}