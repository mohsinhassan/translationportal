<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Translation;

/**
 * SearchTranslation represents the model behind the search form about `backend\models\Translation`.
 */
class SearchTranslation extends Translation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['translation_id', 'label_id', 'is_approved', 'language_id', 'created_by'], 'integer'],
            [['translation', 'created_at'], 'safe'],
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
        $query = Translation::find();

        //adding labels and languages data into search

        $query->joinWith(['language','label','user']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['attributes' => ['translation_id','language_id','window_id', 'created_at']]
        ]);

        $dataProvider->sort->attributes['language.language_name'] = [
            'asc' => ['language.language_name' => SORT_ASC],
            'desc' => ['language.language_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['label.label'] = [
        'asc' => ['label.label' => SORT_ASC],
        'desc' => ['label.label' => SORT_DESC],
    ];

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
       /* $query->andFilterWhere([
            'translation_id' => $this->translation_id,
            'label_id' => $this->label_id,
            'is_approved' => $this->is_approved,
            'language_id' => $this->language_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
        ]);*/

        $query->andFilterWhere(['like', 'translation', $this->translation]);

        //advance search from relation tables

        $query->andFilterWhere([
            'translation_id' => $this->translation_id,
            'translation.label_id' => $this->label_id,
            /*'translation.language_id' => $this->language_id,*/
            /*'translation.window_id' => $this->window_id,*/
            'is_approved' => $this->is_approved,
            'created_at' => $this->created_at,
            /*'updated_at' => $this->updated_at,*/
            /*'updated_by' => $this->updated_by,*/
        ]);
        $query->andFilterWhere(['like', 'translation', $this->translation])
        ->andFilterWhere(['like', 'translation.language_id', $this->language_id])
        ->andFilterWhere(['like', 'created_by', $this->created_by])
       /* ->andFilterWhere(['like', 'label', $this->label])*/;

            /*->andFilterWhere(['like', 'access_key_ios', $this->access_key_ios])

            ->andFilterWhere(['like', 'translation', $this->translation])
            ->andFilterWhere(['like', 'previous_translation', $this->previous_translation])
            ->andFilterWhere(['LIKE', 'languages.language_name', $this->getAttribute('languages.language_id')])
            // ->andFilterWhere(['LIKE', 'language.language_name', $this->language_id])
            ->andFilterWhere(['LIKE', 'screen_windows.window_name',  $this->getAttribute('screen_windows.window_id')]);*/

        return $dataProvider;
    }
}
