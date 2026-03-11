<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "album".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 *
 * @property Photo[] $photos
 * @property User $user
 */
class Album extends \yii\db\ActiveRecord
{


    public static function tableName()
    {
        return '{{%album}}';
    }


    public function fields(): array
    {
        $fields = [
            'id',
            'title'
        ];
        if (\Yii::$app->controller->action->id === 'view') {
            $fields['first_name'] = function ($model) {
                return $model->user ? $model->user->first_name : null;
            };
            $fields['last_name'] = function ($model) {
                return $model->user ? $model->user->last_name : null;
            };
            $fields['photos'] = function ($model) {
                return array_map(function($photo) {
                    return [
                        'id' => $photo->id,
                        'title' => $photo->title,
                        'url' => $photo->getUrl()
                    ];
                }, $model->photos);
            };
        }

        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'title'], 'required'],
            [['user_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[Photos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhotos()
    {
        return $this->hasMany(Photo::class, ['album_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
