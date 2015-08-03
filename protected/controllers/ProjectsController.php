<?php
class ProjectsController extends Controller
{

    public function actions()
    {
        return array(
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    public function actionIndex()
    {
        $this->render('projects_view');
    }

    public function actionSelectProjects()
    {
        $results = array();

        $result = Yii::app()->db->createCommand()
            ->select('p.name_project, p.id_project, upg.cost, upg.admin, SUM(e.end_time-e.start_time) as duration')
            ->from('user_project_group upg')
            ->leftJoin('project p', 'p.id_project=upg.id_project')
            ->leftJoin('event e', 'e.id_upg=upg.id AND e.active=0')
            ->where('upg.id_user=:user', array(':user' => Yii::app()->user->id))
            ->group('p.id_project')
            ->queryAll();

        $team = Yii::app()->db->createCommand()
            ->select('upg.id_project, upg2.id_user, u.name_user, u.email')
            ->from('user_project_group upg')
            ->leftJoin('user_project_group upg2', 'upg2.id_project=upg.id_project')
            ->leftJoin('user u', 'upg2.id_user = u.id')
            ->where('upg.id_user=:user', array(':user' => Yii::app()->user->id))
            ->queryAll();

        foreach($result as $v){
            $results[$v['id_project']] = $v;
        }

        foreach($team as $v){
            $results[$v['id_project']]['team'][$v['id_user']]['name_user'] = $v['name_user'];
            $results[$v['id_project']]['team'][$v['id_user']]['email']     = $v['email'];
        }

        $results[1]['team'][Yii::app()->user->id]['name_user'] = '-'; // For `No project`
        $results[1]['team'][Yii::app()->user->id]['email']     = '-'; // For `No project`

        echo json_encode($results);
    }

    public function actionNewProjects()
    {
        Yii::app()->db->createCommand()->insert('project', array(
            'name_project' => Yii::app()->request->getPost('project'),
        ));

        $last_project_id = Yii::app()->db->getLastInsertId();

        $cost = Yii::app()->request->getPost('cost') ? Yii::app()->request->getPost('cost') : 0;

        Yii::app()->db->createCommand()->insert('user_project_group', array(
            'id_project' => $last_project_id,
            'id_user'    => Yii::app()->user->id,
            'admin'      => 1,
            'cost'       => $cost,
        ));

        echo $last_project_id;
    }

    public function actionDeleteProject()
    {
        //Yii::app()->db->createCommand()->delete('project', 'id_project=:id' , array(':id' => Yii::app()->request->getPost('id_project')));
        Yii::app()->db->createCommand()->delete(
            'user_project_group',
            'id_project=:id_project AND id_user=:id_user' ,
            array(':id_project' => Yii::app()->request->getPost('id_project'), ':id_user' => Yii::app()->user->id)
        );
        print_r(Yii::app()->request->getPost('id_project'));
    }

    public function actionNewMember()
    {
        $email  = Yii::app()->request->getPost('email');
        $subj   = Yii::t('projects_view','subj') . Yii::app()->user->getFirst_Name();
        $header = 'Content-type: text/html; charset=utf8' . "\r\n" .
            'From: Timeman Notification System <noreply@timeman.org>' . "\r\n" .
            'Reply-To: support@timeman.org' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        $user = Yii::app()->db->createCommand()
            ->select('id, name_user')
            ->from('user')
            ->where(
                'email=:email',
                array(':email' => $email)
            )
            ->limit(1)
            ->queryRow();
        $id_user = $user['id'];

        if(!$id_user){
            $name  = strstr($email, '@', true);
            $passw = $name . mt_rand(1001, 9999);
            $confirm = substr(md5(uniqid(rand(), true)), 16, 16);

            Yii::app()->db->createCommand()->insert('user', array(
                'email'        => $email,
                'name_user'    => $name,
                'password'     => $passw,
                'regdate'      => date('Y-m-d H:i:s'),
                'end_pay_day'  => date('Y-m-d H:i:s',mktime(23,59, 59, date("m")+1, date("d"), date("Y"))),
                'spam'         => 1,
                'confirm_code' => $confirm
            ));

            $id_user = Yii::app()->db->getLastInsertId();

            $message = '
                <h1>'. Yii::t('projects_view','new_h1') .'</h1>
                <p>'. Yii::app()->user->getFirst_Name() . Yii::t('projects_view','new_p1_1') . Yii::app()->request->getPost('name_project') . Yii::t('projects_view','new_p1_2') . '</p>
                <p><a href="'. Yii::app()->request->getBaseUrl(true) .'/site/confirm?code='. $confirm .'">'. Yii::t('projects_view','confirm') .'</a></p>
                <p>'. Yii::t('projects_view','p2') .'</p>
                <p>'. $email .'</p>
                <p>'. $passw .'</p>
                <p>'. Yii::t('projects_view','p3') .'</p>
                <p>'. Yii::t('projects_view','p4_1') . '<a href="'. Yii::app()->request->getBaseUrl(true) .'/site/deleteuser?id='. $id_user .'&code='. $confirm .'">'. Yii::t('projects_view','here') .'</a>' .Yii::t('projects_view','p4_2') .'</p>
                <br>
                <p>'. Yii::t('projects_view','footer') .'</p>
            ';
        } else {
            $message = '
                <h1>'. Yii::t('projects_view','h1') . $user['name_user'] . Yii::t('projects_view','h1_2') .'</h1>
                <p>'. Yii::app()->user->getFirst_Name() . Yii::t('projects_view','p1_1') . Yii::app()->request->getPost('name_project') . Yii::t('projects_view','p1_2') .'</p>
                <br>
                <p>'. Yii::t('projects_view','footer') .'</p>
            ';
        }

        $user_in_proj = Yii::app()->db->createCommand()
            ->select('id')
            ->from('user_project_group')
            ->where(
                'id_user=' . $id_user
               .' AND id_project=' . Yii::app()->request->getPost('id_project')
            )
            ->limit(1)
            ->queryRow();

        if($user_in_proj){
            $id_user = 0;
        } else {
            Yii::app()->db->createCommand()->insert('user_project_group', array(
                'id_project' => Yii::app()->request->getPost('id_project'),
                'id_user'    => $id_user,
                'admin'      => 0,
                'cost'       => 0,
            ));

            mail($email, $subj, $message, $header);
        }

        echo $id_user;
    }

    public function actionDeleteMember()
    {
        Yii::app()->db->createCommand()->delete(
            'user_project_group',
            'id_project=:id_project AND id_user=:id_user' ,
            array(':id_project' => Yii::app()->request->getPost('id_project'), ':id_user' => Yii::app()->request->getPost('id_user'))
        );

        Yii::app()->db->createCommand()->delete(
            'user',
            'id=:id AND confirm_code=:conf_code',
            array(':id' => (int) Yii::app()->request->getPost('id_user'), ':conf_code' => '')
        );

        print_r(Yii::app()->request->getPost('id_project'));
    }
}