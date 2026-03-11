<?php

namespace app\models;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 *
 * @property Album[] $albums
 */
class User extends \yii\db\ActiveRecord
{
 
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function fields(): array
    {
        $fields = [
            'id',
            'first_name',
            'last_name'
        ];
        if (\Yii::$app->controller->action->id === 'view') {
            $fields['albums'] = 'albums';
        }
        return $fields;
    }

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'password_hash'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public function getId()
    {
        return $this->id;
    }


    public function getAlbums()
    {
        return $this->hasMany(Album::class, ['user_id' => 'id']);
    }
}
