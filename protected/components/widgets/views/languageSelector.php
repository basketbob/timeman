<?php
    echo '<li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="">
                '. $languages[$currentLang] .'<span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu" id="language">';
    foreach($languages as $key=>$lang) {
        if($key != $currentLang) {
            echo '<li>';
            echo CHtml::link( $lang, $this->getOwner()->createMultilanguageReturnUrl($key));
            echo '</li>';
        }
    }
    echo '</ul></li>';

/*        // Render options as dropDownList
        echo '<li>';
        echo CHtml::form();
        foreach($languages as $key=>$lang) {
            echo CHtml::hiddenField(
                $key,
                $this->getOwner()->createMultilanguageReturnUrl($key));
        }
        echo CHtml::dropDownList('language', $currentLang, $languages,
            array(
                'submit'=>'',
            )
        );
        echo CHtml::endForm();
        echo '</li>';*/
?>