<?php
/**
 * Created by PhpStorm.
 * User: vlkuzin
 * Date: 11/2/14
 * Time: 17:37
 */
class LanguageSelector extends CWidget
{
    public function run()
    {
        $currentLang = Yii::app()->language;
        $languages = Yii::app()->params->languages;
        $this->render('languageSelector', array('currentLang' => $currentLang, 'languages'=>$languages));
    }
}