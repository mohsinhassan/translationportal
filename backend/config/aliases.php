<?php
/**
 * Created by PhpStorm.
 * User: Flexiroam
 * Date: 12/10/2017
 * Time: 3:26 PM
 */
Yii::setAlias('root', dirname(dirname(__DIR__)) . '/backend');
Yii ::setAlias('document_root', 'http://localhost/tp/backend/');
//Yii ::setAlias('document_root', 'http://translate.flexiroamx.com/tp/backend/');
Yii::setAlias('image_path', '@document_root/uploads/');
