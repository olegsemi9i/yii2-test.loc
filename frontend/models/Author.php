<?php

namespace frontend\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string|null $heading
 * @property string|null $name
 * @property string|null $text
 * @property string|null $date_add
 * @property string|null $img
 *
 * @property Message[] $messages
 */
class Author extends \yii\db\ActiveRecord
{
    public $file;
    public $path = 'uploads';
   
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['date_add'], 'safe'],
            [['heading', 'img'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 100],
            
            [['heading', 'name', 'text'], 'required', 'message' => 'Не может быть пустым'],
            [['file'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'heading' => 'Заголовок',
            'name' => 'Имя',
            'text' => 'Текст',
            'date_add' => 'Дата создания',
            'img' => 'Картинка',
        ];
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['author_id' => 'id'])->orderBy('id DESC');;
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
    
    public function beforeDelete()
    {
        foreach ($this->messages as $child) {
            $child->delete();
        }
        return parent::beforeDelete();
    }
    
    
    public function upload()
    {
        if($this->file){
            $name = $this->file->baseName.'.'.$this->file->extension; 
            $this->file->saveAs($this->path.'/'.$name, false);
            $this->img = $name;
        } 
    }
    
    public function getImageurl()
    {
        return \Yii::$app->request->BaseUrl.'/'.$this->path.'/'.$this->img;
    }
    
}