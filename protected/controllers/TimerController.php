<?php

class TimerController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
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
        $result = Yii::app()->db->createCommand()
            ->select('start_time')
            ->from('event')
            ->where('id_user=:user AND active = 1', array(':user' => Yii::app()->user->id))
            ->queryRow();

        $result['start_time'] = isset($result['start_time']) ? $result['start_time']*1000 : 0;
        
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('timer_view', $result);
    }

    public function actionSelectEvents()
    {
        $result = Yii::app()->db->createCommand()
            ->select('e.id_event, e.name_event, e.start_time, e.end_time, 
                      e.active, e.id_project, p.name_project, upg.cost')
            ->from('event e')
            ->leftJoin('project p', 'p.id_project=e.id_project')
            ->leftJoin(
                'user_project_group upg', 
                'e.id_project=upg.id_project 
                AND upg.id_user=:user', array(':user' => Yii::app()->user->id)
            )
            ->where('e.id_user=:user', array(':user' => Yii::app()->user->id))
            ->order('e.end_time desc')
            ->queryAll();

        foreach($result as $v){
            if($v['active'] == 1){
                unset($v['active']);
                $v['start_time'] *= 1000;
                $data['events']['active'] = $v;
                $data['events']['active']['project']['name_project'] = $v['name_project'];
                $data['events']['active']['project']['id_project']   = $v['id_project'];
            } else{
                $v['duration']   = $v['end_time'] - $v['start_time'];
                $v['start_time'] = date('Y-m-d h:i:s', $v['start_time']);
                $v['end_time']   = date('Y-m-d h:i:s', $v['end_time']);
                $data['events']['inactive'][] = $v;
            }
        }

        $data['projects'] = Yii::app()->db->createCommand()
            ->select('p.id_project, p.name_project')
            ->from('user_project_group upg')
            ->leftJoin('project p', 'p.id_project=upg.id_project')
            ->where('upg.id_user=:user', array(':user' => Yii::app()->user->id))
            ->group('p.id_project')
            ->queryAll();

        echo json_encode($data);
    }

    public function actionNewEvent()
    {
        $project = Yii::app()->request->getPost('project');

        $upg = Yii::app()->db->createCommand()
            ->select('id')
            ->from('user_project_group')
            ->where('id_user=:user AND id_project=:project',
                array(':user' => Yii::app()->user->id, 'project' => (int) $project['id_project'])
            )
            ->queryRow();

        Yii::app()->db->createCommand()->insert('event', array(
            'name_event' => Yii::app()->request->getPost('event'),
            'start_time' => time(),
            'end_time'   => 0,
            'active'     => 1,
            'id_user'    => Yii::app()->user->id,
            'id_project' => $project['id_project'],
            'id_upg'     => $upg['id']
        ));
        
        print_r(Yii::app()->request->getPost('event'));
    }

    public function actionStopEvent()
    {
        $bill_duration = Yii::app()->request->getPost('bill') ? Yii::app()->request->getPost('duration') : 0;

        Yii::app()->db->createCommand()->update('event',
            array(
                'end_time'      => time(),
                'active'        => 0,
                'duration'      => Yii::app()->request->getPost('duration'),
                'bill_duration' => $bill_duration,
            ),
            'name_event=:name AND active=1 AND id_user=:user',
            array(':name' => Yii::app()->request->getPost('event'), ':user' => Yii::app()->user->id)
        );
        print_r(Yii::app()->request->getPost('event'));
    }

    public function actionDeleteEvent()
    {
        Yii::app()->db->createCommand()->delete('event', 'id_event=:id' , array(':id' => Yii::app()->request->getPost('id_event')));
        print_r(Yii::app()->request->getPost('id_event'));
    }

    public function actionSettings()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('settings_view');
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