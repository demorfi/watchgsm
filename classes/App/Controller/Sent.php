<?php

namespace App\Controller;

class Sent extends \App\Controller\App
{

    public function action_index()
    {
        $this->view->title    = 'Sent';
        $this->view->messages = $this->pixie->orm->get('sent')->find_all()->as_array();
    }

    protected function sync()
    {
        $sentPath = $this->getHelper()->getConfigVariable('sent');
        $this->readMessages(
            $sentPath,
            function ($fileName, $sign, $content) {
                $sent = $this->pixie->orm->get('sent');
                $sent->where('sign', $sign)->find();
                if (!$sent->loaded()) {
                    $sent->sign     = $sign;
                    $sent->filename = $fileName;

                    // header message to
                    preg_match('/To:[\s](?<to>[\s\S]+?)\n/', $content, $matches);
                    $sent->to = trim($matches['to']);

                    // header message text
                    preg_match('/[\n]{2}(?<text>[\s\S]+)$/', $content, $matches);
                    $sent->text = trim($matches['text']);

                    // header message sent
                    preg_match('/Sent:[\s](?<sent>[\s\S]+?)\n/', $content, $matches);
                    $sent->timestamp = strtotime(trim($matches['sent']));

                    $sent->save();
                }
            }
        );
    }

}
