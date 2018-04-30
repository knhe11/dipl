<?php

namespace app\modelsSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FormatList as FormatListModel;

/**
 * FormatList represents the model behind the search form of `app\models\FormatList`.
 */
class FormatList extends FormatListModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'width_list', 'height_list', 'width_disk'], 'integer'],
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
        $query = FormatListModel::find();

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
            'id' => $this->id,
            'width_list' => $this->width_list,
            'height_list' => $this->height_list,
            'width_disk' => $this->width_disk,
            'edge_plate' => $this->edge_plate,
        ]);

        return $dataProvider;
    }
}
