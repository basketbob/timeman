<?

class ReportsController extends Controller
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
        $this->render('reports_view');
    }
    
    public function actionSelectEvents()
    {
        $data = array();

        $count = Yii::app()->request->getPost('count') ? Yii::app()->request->getPost('count') : 0;
        $period_type = Yii::app()->request->getPost('period') ? Yii::app()->request->getPost('period') : 'Day';

        if($period_type === 'Custom'){
            $period['to']   = strtotime(date('Y-m-d 23:59:59', strtotime(Yii::app()->request->getPost('to'))));
            $period['from'] = strtotime(date('Y-m-d 00:00:00', strtotime(Yii::app()->request->getPost('from'))));
        } else {
            $period = self::period($count, $period_type);
        }

        $result = Yii::app()->db->createCommand()
            ->select('e.name_event, p.name_project, e.duration, e.bill_duration, e.start_time, e.end_time, upg.cost, u.name_user')
            ->from('user_project_group upg')
            ->leftJoin('user_project_group upg2','upg2.id_project=upg.id_project
                AND (upg.admin=1 OR (upg2.id_user=:user AND upg.admin=0))', array(':user' => Yii::app()->user->id)
            )
            ->leftJoin('project p','p.id_project=upg.id_project')
            ->leftJoin('user u','u.id=upg2.id_user OR (upg.id_project=1 AND upg.id_user=u.id)')
            ->leftJoin('event e','(upg2.id=e.id_upg OR (upg.id_project=1 AND e.id_upg=upg.id))
                AND e.active = 0 AND (e.end_time BETWEEN '. $period['from'] .' AND '. $period['to'] .')')
            ->where('upg.id_user=:user AND e.name_event IS NOT NULL', array(':user' => Yii::app()->user->id))
            ->order('e.end_time desc')
            ->queryAll();

        if(count($result) > 0){
            foreach($result as $v){
                $hours = floor($v['duration'] / 3600);
                $mins  = floor(($v['duration'] - ($hours*3600)) / 60);
                $v['duration'] = $hours . ':' . $mins;

                $bill_hours = floor($v['bill_duration'] / 3600);
                $bill_mins  = floor(($v['bill_duration'] - ($bill_hours*3600)) / 60);
                $v['bill_duration'] = $bill_hours . ':' . $bill_mins;

                $v['cost'] = $bill_hours * $v['cost'];

                $v['start_time'] = date('Y-m-d h:i:s', $v['start_time']);
                $v['end_time']   = date('Y-m-d h:i:s', $v['end_time']);

                $data['events'][]   = $v;
                $data['projects'][] = $v['name_project'];
            }

            $data['projects'] = array_unique($data['projects']);
        }

        $data['period']   = array(
            'to'   => date('Y/m/d',$period['to']),
            'from' => date('Y/m/d',$period['from'])
        );

        echo json_encode($data);
    }

    public function actionSendReport(){
        $email   = Yii::app()->request->getPost('email');
        $subject = 'Report from ' . Yii::app()->user->getFirst_Name();
        $message = trim(Yii::app()->request->getPost('events'));
        $header  = 'Content-type: text/html; charset=utf8' . "\r\n" .
            'From: Timeman <noreply@timeman.org>' . "\r\n" .
            'Reply-To: ' . Yii::app()->user->name . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        echo mail($email, $subject, $message, $header);
    }

    private static function period($count=0, $period='Day'){
        $result = array();
        switch($period) {
            case 'Day':
                $result['to']   = date('Y-m-d 23:59:59', strtotime('-'. $count .' Day'));
                $result['from'] = date('Y-m-d 00:00:00', strtotime($result['to']));
                break;
            case 'Week':
                $week = date('Y-m-d', strtotime('-'. $count .'Week'));;
                $result['to']   = date('Y-m-d', strtotime($week ." Sunday"));
                $result['from'] = date('Y-m-d', strtotime($result['to'] . ' - 6 Day'));
                break;
            case 'Month':
                $result['to']   = date('Y-m-t 23:59:59', strtotime('-'. $count .' Month'));
                $result['from'] = date('Y-m-01 00:00:00', strtotime($result['to']));
                break;
            case 'Year':
                $result['to']   = date('Y-12-31 23:59:59', strtotime('-'. $count .' Year'));
                $result['from'] = date('Y-01-01 00:00:00', strtotime($result['to']));
                break;
        }

        foreach($result as &$v){
            $v = strtotime($v);
        }

        return $result;
    }
}