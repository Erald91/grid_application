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
            'pranishem' => 'State',
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
            $query = Yii::$app->db
            ->createCommand('
                SELECT COUNT(*) AS count, pranishem AS state 
                FROM record 
                WHERE qendra_id = "' . $center->qendra_id . '"
                GROUP BY pranishem');
            $result = $query->queryAll();

            $states = Record::_getListOfStates($result);
            return [
                'qendra_id' => $center->qendra_id,
                'total' => $states['0'] + $states['1'] + $states['2'] + $states['3'],
                'potential' => $states['1'],
                'potential_done' => $states['2'],
                'casual' => $states['0'],
                'casual_done' => $states['3']
            ];
        }, $ids);

        return [
            'success'=>'Data retrieved successfully', 
            'data' => $data
        ];
    }

    /**
     * Returns list of state for specific center
     *
     * @param array result from database query
     * @return array of parsed data
     */
    private static function _getListOfStates($result) {
        $states = [];
        foreach($result as $record) {
            $states[$record['state']] = $record['count'];
        }

        if(!isset($states[0])) $states[0] = 0;
        if(!isset($states[1])) $states[1] = 0;
        if(!isset($states[2])) $states[2] = 0;
        if(!isset($states[3])) $states[3] = 0;

        return $states;
    }
}
