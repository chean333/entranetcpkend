<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "knowledge".
 *
 * @property int $id
 * @property string $name
 * @property string $knowledge
 */
class Knowledge extends \yii\db\ActiveRecord
{
    public $uploadFilesFolder = 'uploads/files'; //ที่เก็บไฟล์

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'knowledge';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
      //ใช้ในการกำหนดความยาวของตัวอักษรให้ยาวขนาดเท่าไหร่
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['name', 'knowledge'], 'string', 'max' => 1000000000000],//ความยาวจำนวนตัวหนังสือ
            [['id'], 'unique'],
            [['files'], 'file', 'maxFiles' =>10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ลำดับ',
            'name' => 'ใส่คำค้นหาที่นี้',
            'knowledge' => 'เนื้อหา',
            'files' => 'ไฟล์แนบ',
        ];
    }

    /*
    * UploadFiles เป็น Method ในการ upload หลายไฟล์ สูงสุด 10 ไฟล์ตามที่ได้กำหนดจาก rules() และจะ return ชื่อไฟล์ aaaa.aaa, bbbb.bbb, ....
    */
    public function uploadFiles(){
        $filesName = []; //กำหนดชื่อไฟล์ที่จะ return
        if($this->validate()){
            if($this->files){
                foreach($this->files as $file){
                    $fileName = substr(md5(rand(1,1000).time()),0,15).'.'.$file->extension;//เลือกมา 15 อักษร .นามสกุล
//$fileName = iconv('UTF-8','WINDOWS-874',$file->baseName).'.'.$file->extension; //ใช้ไฟล์ภาษาไทย
                    $file->saveAs(Yii::getAlias('@webroot').'/'.$this->uploadFilesFolder.'/'.$fileName);
                    $filesName[] = $fileName;
                }

                if($this->isNewRecord){ //ถ้าเป็นการเพิ่ม Record ใหม่ให้บันทึกไฟล์ aaa.aaa,bbb.bbb ....
                    return implode(',', $filesName);
                }else{//ถ้าเป็นการปรับปรุงให้เพิ่มจากของเดิม
                    return implode(',', [ArrayHelper::merge($fileName, is_array($this->getOldAttribute('files')) ? explode(',', $this->getOldAttribute('files')) : [])]);
                }
            }//end files upload

        }//end validate
        return $this->isNewRecord ? false : $this->getOldAttribute('files'); //ถ้าไม่มีการ upload ให้ใช้ข้อมูลเดิม
    }

    /*
    * getFiles เป็น method สำหรับเรียกชื่อไฟล์ให้อยู่ในรูปของ array
    */
    public function getFiles()
    {
        return explode(',', $this->files);
    }

}
