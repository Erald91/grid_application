<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "record".
 *
 * @property integer $id
 * @property string $qendra_id
 * @property string $emertimi
 * @property string $date_lindja
 * @property integer $nr_rendor
 * @property integer $pranishem
 */
class Record extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qendra_id', 'emertimi', 'date_lindja', 'nr_rendor'], 'required'],
            [['nr_rendor', 'pranishem'], 'integer'],
            [['qendra_id', 'emertimi', 'date_lindja'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'qendra_id' => 'Qendra ID',
            'emertimi' => 'Emertimi',
            'date_lindja' => 'Datelindja',
            'nr_rendor' => 'Nr. Rendor',
            'pranishem' => 'Paraqitur',
        ];
    }

    /**
     * Parses data retrieved from ActiveQuery
     * 
     * @return array of data
     */
    public static function parseData($objectData) 
    {
        return array_map(function($object) {
            return [
                'id' => $object->id,
                'qendra_id' => $object->qendra_id,
                'emertimi' => $object->emertimi,
                'date_lindja' => $object->date_lindja,
                'pranishem' => $object->pranishem,
                'nr_rendor' => $object->nr_rendor
            ];
        }, $objectData);
    }

    /**
     * Returns data for election centers
     *
     * @return array of data
     */
    public static function retrieveCentersMainStatistics() {
        $ids = Record::find()->select(['qendra_id'])
                             ->distinct(true)
                             ->where('1=1')
                             ->orderBy('qendra_id')
                             ->all();

        $data = array_map(function($center) {
            # Retrieve active query from Record model
            $activeQuery = Record::find();
            # Define identifier 
            $centerId = $center->qendra_id;
            # Add WHERE clause
            $activeQuery->where(['qendra_id' => $centerId]);
            # Calculate total records per center
            $total = $activeQuery->count();
            # Calculate how many from records have successfully partecipated
            $activeQuery->andWhere(['pranishem' => 1]);
            $participated = $activeQuery->count();
            # Calculate how many have not participated
            $notParticipated = $total - $participated;
            return [
                'qendra_id' => $centerId,
                'total' => $total,
                'participated' => $participated,
                'notParticipated' => $notParticipated
            ];
        }, $ids);

        return [
            'success'=>'Data retrieved successfully', 
            'data' => $data
        ];
    }
}
