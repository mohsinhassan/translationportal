<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Screenshot;

/**
 * SearchScreenshot represents the model behind the search form about `backend\models\Screenshot`.
 */
class SearchScreenshot extends Screenshot
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['screenshot_id', 'window_id'], 'integer'],
            [['image', 'created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Screenshot::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'screenshot_id' => $this->screenshot_id,
            'window_id' => $this->window_id,
            /*'created_at' => $this->created_at,*/
        ]);

        //$query->andFilterWhere(['like', 'image', $this->image])
        $query->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
