<?php

class InvoicesController extends Controller
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
        if(Yii::app()->user->isGuest) $this->redirect('/');

        $this->render('invoices_view');
    }

    public function actionSelectData()
    {
        $results = array();

        $results['invoices'] = Yii::app()->db->createCommand()
            ->select('i.id_invoice,i.create, i.payday, i.client_name, i.client_email, i.paid, p.name_project')
            ->from('invoice i')
            ->leftJoin('project p', 'p.id_project=i.id_project')
            ->where(
                'i.id_user=:user',
                array(':user' => Yii::app()->user->id)
            )
            ->queryAll();

        $results['projects'] = Yii::app()->db->createCommand()
            ->select('p.name_project, p.id_project')
            ->from('user_project_group upg')
            ->leftJoin('project p', 'p.id_project=upg.id_project')
            ->where(
                'upg.id_user=:user AND upg.id_project != 1',
                array(':user' => Yii::app()->user->id)
            )
            ->queryAll();

        echo json_encode($results);
    }



    public function actionSelectForInvoice()
    {
        $results = array();
        $period['to']   = strtotime(date('Y-m-d 23:59:59', strtotime(Yii::app()->request->getPost('to'))));
        $period['from'] = strtotime(date('Y-m-d 00:00:00', strtotime(Yii::app()->request->getPost('from'))));
        $id_project     = (int) Yii::app()->request->getPost('id_project');

        $result = Yii::app()->db->createCommand()
            ->select('e.name_event, e.bill_duration, upg.cost')
            ->from('event e')
            ->leftJoin(
                'user_project_group upg',
                'e.id_project=upg.id_project
                AND upg.id_user=:user', array(':user' => Yii::app()->user->id)
            )
            ->where(
                'e.id_user=:user AND e.active = 0 AND e.id_project=:id_proj
                AND (e.end_time BETWEEN '. $period['from'] .' AND '. $period['to'] .')',
                array(':user' => Yii::app()->user->id, ':id_proj' => $id_project)
            )
            ->queryAll();

        $results['total'] = 0;
        foreach($result as $k => $v){
            $results['table'][$k]['name_event']    = $v['name_event'];
            $results['table'][$k]['cost']          = $v['cost'];
            $results['table'][$k]['bill_duration'] = round($v['bill_duration'] / 60 / 60, 1);
            $results['table'][$k]['sub_total']     = $results['table'][$k]['bill_duration'] * $v['cost'];

            $results['total'] += $results['table'][$k]['sub_total'];
        }

        echo json_encode($results);
    }

    public function actionSaveInvoice(){
        $data = array();
        $data['proj']   = Yii::app()->request->getPost('proj');
        $data['name']   = Yii::app()->request->getPost('name');
        $data['email']  = Yii::app()->request->getPost('email');
        $data['payday'] = strtotime(Yii::app()->request->getPost('payday'));
        $data['payment']= Yii::app()->request->getPost('payment');
        $data['other']  = Yii::app()->request->getPost('other');

        Yii::app()->db->createCommand()->insert('invoice', array(
            'create'      => time(),
            'payday'      => $data['payday'],
            'id_project'  => $data['proj']['id_project'],
            'id_user'     => Yii::app()->user->id,
            'client_name' => $data['name'],
            'client_email'=> $data['email'],
            'paid' => 0,
        ));

        echo Yii::app()->db->getLastInsertId();
    }

    public function actionSendInvoice(){
        $data = array();
        $data['id_invoice'] = Yii::app()->request->getPost('id_invoice');
        $data['me_copy']= Yii::app()->request->getPost('me_copy') ? ','.Yii::app()->user->name : '';
        $data['proj']   = Yii::app()->request->getPost('proj');
        $data['name']   = Yii::app()->request->getPost('name');
        $data['email']  = Yii::app()->request->getPost('email') . $data['me_copy'];
        $data['from']   = strtotime(Yii::app()->request->getPost('from'));
        $data['to']     = strtotime(Yii::app()->request->getPost('to'));
        $data['payday'] = strtotime(Yii::app()->request->getPost('payday'));
        $data['payment']= Yii::app()->request->getPost('payment');
        $data['other']  = Yii::app()->request->getPost('other');

        $data['subj']   = 'Invoice #'. $data['id_invoice'] .' from '. Yii::app()->user->getFirst_Name() .', due '. Yii::app()->request->getPost('payday');
        $data['header'] = 'Content-type: text/html; charset=utf8' . "\r\n" .
            'From: Timeman <noreply@timeman.org>' . "\r\n" .
            'Reply-To: ' . Yii::app()->user->name . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        $data['events'] = Yii::app()->request->getPost('events');
        if(isset($data['events']['$$hashKey'])) unset($data['events']['$$hashKey']);

        $data['message'] = '';
        $data['message'] .= '
            <p>'. $data['other'] .'</p>
            <table style="width: 100%; padding: 10px 15px;">
                <tr>
                    <td><img src="http://timeman.org/images/invoices_logo.png" alt="Logo"/></td>
                    <td><h1 style="text-align: right;">'. Yii::t('invoices_view','invoice') .' #'. $data['id_invoice'] .'</h1></td>
                </tr>
                <tr>
                    <td><h1 style="font-size: 80%;color: #777;">'. Yii::t('invoices_view','for') .' "'. $data['proj']['name_project'] .'"' . '</h1></td>
                    <td></td>
                </tr>
            </table>
            <table style="width: 100%; margin-bottom: 20px; border-spacing: 0;">
                <tr>
                    <td>
                        <table style="width: 100%; margin-bottom: 20px; border-spacing: 0;">
                            <tr>
                                <td style="background-color: #f5f5f5; padding: 10px 15px;border: 1px solid #ddd;"><h4>'. Yii::t('invoices_view','from_name') .': '. Yii::app()->user->getFirst_Name() .'</h4></td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 15px;border: 1px solid #ddd;">'. Yii::t('invoices_view','email') .': '. Yii::app()->user->name .'</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 15px;border: 1px solid #ddd; border-top: 0;">'. Yii::t('invoices_view','payment') .': '. $data['payment'] .'</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 15px;border: 1px solid #ddd; border-top: 0;">'. Yii::t('invoices_view','payday') .': '. $data['payday'] .'</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 15%"></td>
                    <td style="vertical-align: top;">
                        <table style="width: 100%; margin-bottom: 20px; border-spacing: 0;">
                            <tr>
                                <td style="background-color: #f5f5f5;text-align: right; padding: 10px 15px;border: 1px solid #ddd;"><h4>'. Yii::t('invoices_view','to_name') .': '. $data['name'] .'</h4></td>
                            </tr>
                            <tr>
                                <td style="text-align: right; padding: 10px 15px;border: 1px solid #ddd;">'. Yii::t('invoices_view','email') .': '. $data['email'] .'</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table style="width: 100%; border: 1px solid #ddd; margin-bottom: 20px;border-spacing: 0;">
                <thead>
                    <tr>
                        <th style="padding-top: 10px; border: 1px solid #ddd;"><h4>#</h4></th>
                        <th style="padding-top: 10px; border: 1px solid #ddd;"><h4>'. Yii::t('invoices_view','table_event') .'</h4></th>
                        <th style="padding-top: 10px; border: 1px solid #ddd;"><h4>'. Yii::t('invoices_view','table_hours') .'</h4></th>
                        <th style="padding-top: 10px; border: 1px solid #ddd;"><h4>'. Yii::t('invoices_view','table_price') .'</h4></th>
                        <th style="padding-top: 10px; border: 1px solid #ddd;"><h4>'. Yii::t('invoices_view','sub_total') .'</h4></th>
                    </tr>
                </thead>
                <tbody>';

        $i = 0;
        foreach($data['events']['table'] as $v){
            $i++;
            $data['message'] .= '
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">'. $i .'</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">'. $v['name_event'] .'</td>
                    <td style="padding: 10px; border: 1px solid #ddd;text-align: right;">'. $v['bill_duration'] .'</td>
                    <td style="padding: 10px; border: 1px solid #ddd;text-align: right;">$'. $v['cost'] .'</td>
                    <td style="padding: 10px; border: 1px solid #ddd;text-align: right;">$'. $v['sub_total'] .'</td>
                </tr>';
        }
        $data['message'] .= '
            </tbody></table>
            <table style="width: 100%; font-weight: 600;">
                <tr>
                    <td style="width: 60%;"></td>
                    <td style="text-align: right;">'. Yii::t('invoices_view','total') .':</td>
                    <td style="text-align: right;">$'. $data['events']['total'] .'</td>
                </tr>
            </table>';

        echo mail($data['email'], $data['subj'], $data['message'], $data['header']);
    }

    public function actionInvoicePaid(){
        Yii::app()->db->createCommand()->update('invoice', array( 'paid' => 1 ), 'id_invoice=:id',
            array(':id' => (int) Yii::app()->request->getPost('id_invoice'))
        );

        print_r(Yii::app()->request->getPost('id_invoice'));
    }

    public function actionDeleteInvoice()
    {
        Yii::app()->db->createCommand()->delete('invoice', 'id_invoice=:id',
            array(':id' => (int) Yii::app()->request->getPost('id_invoice'))
        );

        print_r(Yii::app()->request->getPost('id_invoice'));
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