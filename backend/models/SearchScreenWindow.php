<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ScreenWindow;

/**
 * SearchScreenWindow represents the model behind the search form about `backend\models\ScreenWindow`.
 */
class SearchScreenWindow extends ScreenWindow
{
    public $image;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['window_id','type_id'], 'integer'],
            [['window_name', 'type_id', 'created_at','image'], 'safe'],
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
    //getting screen shots relation data
    public function getScreenshot()
    {
        return $this->hasMany(Screenshot::className(), ['screen_windows_id' => 'window_id']);
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
        $query = ScreenWindow::find();
        $query->joinWith("screenshot");
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
            'window_id' => $this->window_id,
           /* 'screen_windows.created_at' => $this->created_at,*/
        ]);

        $query->andFilterWhere(['like', 'window_name', $this->window_name])
            ->andFilterWhere(['like', 'type_id', $this->type_id])
            ->andFilterWhere(['like', 'screen_windows.created_at', $this->created_at])
            ->andFilterWhere(['like', 'screenshots.screen_windows_id', $this->window_id]);

        return $dataProvider;
    }
}
