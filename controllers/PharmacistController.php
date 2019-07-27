<?php

namespace app\controllers;

use app\models\CustomerAppointmentSearch;
use app\models\CustomerPurchaseSearch;
use Yii;
use app\models\Pharmacist;
use app\models\PharmacistSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
/**
 * PharmacistController implements the CRUD actions for Pharmacist model.
 */
class PharmacistController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Pharmacist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PharmacistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pharmacist model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Pharmacist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pharmacist();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->u_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Pharmacist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->u_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Pharmacist model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * 待审核列表
     * @param int $option
     * @param string order
     * @return string
     */
    public function actionList($option = 0, $order = '') {
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . '../../prescription';
        $files = scandir($dir);
        $orders = [];
        $count = 0;
        unset($files[0]);
        unset($files[1]);
        foreach($files as $file) {
            $orders[$count] = substr($file, 0, strlen($file)-4);
            $count++;
        }

        //$searchModel = new CustomerPurchaseSearch();
        //$dataProvider = $searchModel->searchByParams(['cp_order' => $files]);
        $searchModel = new CustomerAppointmentSearch();
        $caProvider = $searchModel->pharmacistSearch($orders);

        print_r($orders);
        return $this->render('list', [
            'caProvider' => $caProvider,
        ]);
    }

    /**
     * Finds the Pharmacist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pharmacist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pharmacist::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
