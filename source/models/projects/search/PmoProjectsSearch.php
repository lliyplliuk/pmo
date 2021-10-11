<?php

namespace app\models\projects\search;

use app\extensions\provider\ActiveDataProviderProjects;
use app\models\projects\PmoDirections;
use app\models\projects\PmoProjectResources;
use app\models\projects\PmoProjects;
use app\models\projects\PmoResource;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class PmoProjectsSearch extends PmoProjects
{
    public $pm;

    public function rules()
    {
        return [
            [['name'], 'safe'],
            [['pm', 'is_strategic'], 'number'],
        ];
    }


    public function search($params)
    {
        $this->load($params);
        $query = PmoProjects::find()->
        joinWith(['resources', 'resources.res']);
        if ($this->pm) {
            $id_author = PmoResource::find()->where(['id' => $this->pm])->one();
            if (isset($id_author->id_user))
                $query->andFilterWhere(['=', PmoProjects::tableName() . '.id_author', $id_author->id_user]);
            $query->orWhere([PmoProjectResources::tableName() . '.id_resource' => $this->pm, PmoProjectResources::tableName() . '.id_role' => 1]);
            //$query->andWhere(['=', PmoProjectResources::tableName() . '.id_role', 1]);
        } else {
            $needDirection = PmoResource::find()->where(['id_user' => (Yii::$app->user->identity->id ?? 0)])->one();
            if (isset($needDirection->id_direction)) {
                //$query->orWhere([PmoResource::tableName() . '.id_direction' => $needDirection->id_direction]);
                $authors = ArrayHelper::map(PmoResource::find()->where(['id_direction' => $needDirection->id_direction])->all(), 'id_user', 'id_user');
                $query->orWhere([PmoProjects::tableName() . '.id_author' => $authors]);
            }
            $query->orWhere([self::tableName() . '.id_author' => (Yii::$app->user->identity->id ?? 0)])->
            orWhere([PmoResource::tableName() . '.id_user' => (Yii::$app->user->identity->id ?? 0)]);
        }
        $query->andWhere(['deleted' => 0]);
        $query->groupBy('id');
        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $provider->pagination = [
            'pageSize' => 20,
        ];
        if (!$this->validate()) {
            return $provider;
        }
        $query->andFilterWhere(['like', self::tableName() . '.name', $this->name]);
        $query->andFilterWhere(['=', self::tableName() . '.is_strategic', $this->is_strategic]);
//        $query->andFilterWhere(['like', Items::tableName() . '.title', $this->itemTitle]);
//        if (isset($this->itemCategoryName))
//            $query->andFilterWhere(['like', EbayCategories::tableName() . '.name', $this->itemCategoryName]);
//        if (isset($this->sku))
//            $query->andFilterWhere(['like', self::tableName() . '.sku', $this->sku]);
//        if (isset($this->gtin))
//            $query->andFilterWhere(['like', self::tableName() . '.gtin', $this->gtin]);
        return $provider;
    }
}