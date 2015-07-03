<?php

namespace App\Controller;

class Turn extends \App\Controller\App
{

    public function action_index()
    {
        $this->view->title    = 'Turn';
        $this->view->messages = $this->pixie->orm->get('turn')->find_all()->as_array();
    }

    protected function sync()
    {
        $turnPath = $this->getHelper()->getConfigVariable('turn');
        $this->readMessages(
            $turnPath,
            function ($fileName, $sign, $content) {
                $turn = $this->pixie->orm->get('turn');
                $turn->where('sign', $sign)->find();
                if (!$turn->loaded()) {
                    $turn->sign     = $sign;
                    $turn->filename = $fileName;

                    // header message to
                    preg_match('/To:[\s](?<to>[\s\S]+?)\n/', $content, $matches);
                    $turn->to = trim($matches['to']);

                    // header message text
                    preg_match('/[\n]{1}(?<text>[\s\S]+)$/', $content, $matches);
                    $turn->text = trim($matches['text']);

                    // header message sent
                    preg_match('/Sent:[\s](?<sent>[\s\S]+?)\n/', $content, $matches);
                    $turn->timestamp = strtotime(trim($matches['sent']));

                    $turn->save();
                }
            }
        );
    }

}
