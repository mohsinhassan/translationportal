<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SystemLabel;

/**
 * SearchSystemLabel represents the model behind the search form about `backend\models\SystemLabel`.
 */
class SearchSystemLabel extends SystemLabel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label_id', 'window_id'], 'integer'],
            [['access_key_android', 'access_key_ios', 'label', 'created_at', 'updated_at'], 'safe'],
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
        $query = SystemLabel::find();

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
            'label_id' => $this->label_id,
            'window_id' => $this->window_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'access_key_android', $this->access_key_android])
            ->andFilterWhere(['like', 'access_key_ios', $this->access_key_ios])
            ->andFilterWhere(['like', 'label', $this->label]);

        return $dataProvider;
    }
}
