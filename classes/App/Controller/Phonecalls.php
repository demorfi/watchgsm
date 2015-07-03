<?php

namespace App\Controller;

class Phonecalls extends \App\Controller\App
{

    public function action_index()
    {
        $this->view->title = 'Phone Calls';
        $this->view->calls = $this->pixie->orm->get('phonecalls')->find_all()->as_array();
    }

    protected function sync()
    {
        $callsPath = $this->getHelper()->getConfigVariable('phonecalls');
        $this->readMessages(
            $callsPath,
            function ($fileName, $sign, $content) {
                $call = $this->pixie->orm->get('phonecalls');
                $call->where('sign', $sign)->find();
                if (!$call->loaded()) {
                    $call->sign     = $sign;
                    $call->filename = $fileName;

                    // header message from
                    preg_match('/From:[\s](?<from>[\s\S]+?)\n/', $content, $matches);
                    $call->from = trim($matches['from']);

                    // header message text
                    preg_match('/[\n]{2}(?<text>[\s\S]+)$/', $content, $matches);
                    $call->text = trim($matches['text']);

                    // header message sent
                    preg_match('/Received:[\s](?<sent>[\s\S]+?)\n/', $content, $matches);
                    $call->timestamp = strtotime(trim($matches['sent']));

                    $call->save();
                }
            }
        );
    }

}
