<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property int $author_id
 * @property string $text
 * @property string|null $date_add
 *
 * @property Author $author
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'text'], 'required'],
            [['author_id'], 'integer'],
            [['text'], 'string'],
            [['date_add'], 'safe'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::className(), 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'text' => 'Text',
            'date_add' => 'Date Add',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['id' => 'author_id']);
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
     
            if ($this->isNewRecord) 
                $this->date_add = date("Y-m-d H:i:s");

            return true;
        }
        return false;
    }
    
   
    
    
}