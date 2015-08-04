<?php

namespace App\Controller;

class Turn extends \App\Controller\App
{

    public function action_index()
    {
        $this->view->title = 'Turn';

        // remove turn messages
        if ($this->request->method == 'POST') {
            $turnPath = $this->pixie->get_smstools_var('outgoing');
            foreach ($this->request->post('messagesId') as $messageId) {
                $turn = $this->pixie->orm->get('turn', $messageId);
                if ($turn->loaded()) {
                    $this->pixie->remove_message_file($turnPath . DIRECTORY_SEPARATOR . $turn->filename);
                    $turn->delete();
                }
            }
            $this->add_message_success('Messages removed!');
        }

        $this->view->messages = $this->pixie->orm->get('turn')
            ->order_by('timestamp', 'asc')
            ->find_all()
            ->as_array();
    }

    protected function sync()
    {
        $turnPath = $this->pixie->get_smstools_var('outgoing');
        $this->pixie->read_messages(
            $turnPath,
            function ($fileName, $sign, $content) {
                $turn = $this->pixie->orm->get('turn')->where('sign', $sign)->find();
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
