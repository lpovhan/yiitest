<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "photo".
 *
 * @property int $id
 * @property int $album_id
 * @property string $title
 * @property string $url
 *
 * @property Album $album
 */
class Photo extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%photo}}';
    }

    public function fields(): array
    {
        $fields = [
            'id',
            'title',
            'url'
        ];
        return $fields;
    }

    public function rules()
    {
        return [
            [['album_id', 'title', 'url'], 'required'],
            [['album_id'], 'integer'],
            [['title', 'url'], 'string', 'max' => 255],
            [['album_id'], 'exist', 'skipOnError' => true, 'targetClass' => Album::class, 'targetAttribute' => ['album_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'album_id' => 'Album ID',
            'title' => 'Title',
            'url' => 'Url',
        ];
    }

    /**
     * Gets query for [[Album]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlbum()
    {
        return $this->hasOne(Album::class, ['id' => 'album_id']);
    }

    public function getUrl()
    {
        $baseUrl = \Yii::$app->request->hostInfo;

        return $baseUrl . DIRECTORY_SEPARATOR . Yii::$app->params['seedImagesUrl'] . $this->url;
    }
}
