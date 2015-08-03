<?php

class ProfileController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        if(Yii::app()->user->isGuest)
            $this->redirect('/');

        return array(
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('profile_view');
    }

    public function actionSelectProfile()
    {
        $result = Yii::app()->db->createCommand()
            ->select('name_user, email, department, timezone, img')
            ->from('user')
            //->leftJoin('project p', 'p.id_project=e.id_project')
            ->where('id=:user', array(':user' => Yii::app()->user->id))
            //->order('e.end_time desc')
            ->queryAll();

        if($result[0]['img'] != ''){
            $result[0]['img'] = Yii::app()->user->id . '.' . $result[0]['img'];
        }

        echo json_encode($result[0]);
    }

    public function actionCheckPassword()
    {
        $result = Yii::app()->db->createCommand()
            ->select('id')
            ->from('user')
            ->where(
                'id=:user AND password=:password',
                array(':user' => Yii::app()->user->id, ':password' => Yii::app()->request->getPost('password'))
            )
            ->limit(1)
            ->queryRow();

        print_r($result);
    }

    public function actionUpdateProfile()
    {
        $profile = array(
            'name'       => CHtml::encode(Yii::app()->request->getPost('name_user')),
            'department' => CHtml::encode(Yii::app()->request->getPost('department')),
            'timezone'   => (int) Yii::app()->request->getPost('timezone'),

            'password'        => Yii::app()->request->getPost('password'),
            'new_password'    => Yii::app()->request->getPost('new_password'),
            'repeat_password' => Yii::app()->request->getPost('repeat_password'),
        );

        if($profile['new_password'] != ''){
            $checkPassword = Yii::app()->db->createCommand()
                ->select('id')
                ->from('user')
                ->where(
                    'id=:user AND password=:password',
                    array(':user' => Yii::app()->user->id, ':password' => Yii::app()->request->getPost('password'))
                )
                ->limit(1)
                ->queryRow();

            if($profile['new_password'] === $profile['repeat_password'] && $checkPassword){
                $result = Yii::app()->db->createCommand()->update('user',
                    array(
                        'name_user'  => $profile['name'],
                        'department' => $profile['department'],
                        'timezone'   => $profile['timezone'],
                        'password'   => $profile['new_password'],
                    ),
                    'id=:user',
                    array(
                        ':user' => Yii::app()->user->id,
                    )
                );
            } else {
                $result = false;
            }
        } else {
            $result = Yii::app()->db->createCommand()->update('user',
                array(
                    'name_user'     => $profile['name'],
                    'department'    => $profile['department'],
                    'timezone'      => $profile['timezone'],
                ),
                'id=:user',
                array(
                    ':user' => Yii::app()->user->id,
                )
            );
        }

        print_r($result);
    }

    public function actionUpdate(){
        $types = array('image/png', 'image/jpeg', 'image/gif');

        if(isset($_FILES['avatar']) && in_array($_FILES['avatar']['type'], $types) && $_FILES['avatar']['size'] <= 1048576){
            $type = explode('/',$_FILES['avatar']['type']);
            $type = ($type[1] == 'jpeg') ? 'jpg' : $type[1];
            $uploadfile = realpath(Yii::app()->basePath . '/../images/avatar') . '/' . Yii::app()->user->id . '.' . $type;

            move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadfile);

            $result = Yii::app()->db->createCommand()->update('user',
                array(
                    'img' => $type,
                ),
                'id=:user',
                array(
                    ':user' => Yii::app()->user->id,
                )
            );
        }

        $this->redirect(array('/profile/index'));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
}