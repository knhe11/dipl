<?php

namespace app\modelsSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OrderItem as OrderItemModel;

/**
 * FormatList represents the model behind the search form of `app\models\FormatList`.
 */
class OrderItem extends OrderItemModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_order', 'width_item', 'height_item', 'count_item'], 'integer'],
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
        $query = OrderItemModel::find();

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
            'id_order' => $this->id_order,
            'width_item' => $this->width_item,
            'height_item' => $this->height_item,
            'count_item' => $this->count_item,
        ]);

        return $dataProvider;
    }
}
