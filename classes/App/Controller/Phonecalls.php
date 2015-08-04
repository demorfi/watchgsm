<?php

namespace App\Controller;

class Phonecalls extends \App\Controller\App
{

    public function action_index()
    {
        $this->view->title = 'Phone Calls';

        // remove phone calls
        if ($this->request->method == 'POST') {
            $callsPath = $this->pixie->get_smstools_var('phonecalls');
            foreach ($this->request->post('callsId') as $callId) {
                $call = $this->pixie->orm->get('phonecalls', $callId);
                if ($call->loaded()) {
                    $this->pixie->remove_message_file($callsPath . DIRECTORY_SEPARATOR . $call->filename);
                    $call->delete();
                }
            }
            $this->add_message_success('Phone call removed!');
        }

        $this->view->calls = $this->pixie->orm->get('phonecalls')
            ->order_by('timestamp', 'asc')
            ->find_all()
            ->as_array();
    }

    protected function sync()
    {
        $callsPath = $this->pixie->get_smstools_var('phonecalls');
        $this->pixie->read_messages(
            $callsPath,
            function ($fileName, $sign, $content) {
                $call = $this->pixie->orm->get('phonecalls')->where('sign', $sign)->find();
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
