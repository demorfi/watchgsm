<?php

namespace App\Controller;

class Turn extends \App\Controller\App
{

    public function action_index()
    {
        $this->view->title = 'Turn';

        // remove turn messages
        if ($this->request->method == 'POST') {
            foreach ($this->request->post('messagesId', array()) as $messageId) {
                $turn = $this->pixie->orm->get('turn', $messageId);
                if ($turn->loaded()) {
                    $turn->delete();
                }
            }
            $this->add_message_success('Messages removed!');
        }

        // scheduled messages
        $turn = $this->pixie->orm->get('turn')->order_by('timestamp', 'asc');
        $this->add_view_data('messages', $turn->find_all());
        $this->add_view_data('total_messages', (int)$turn->count_all());

        // messages waiting to be sent
        $outMessages = [];
        $this->pixie->read_messages(
            $this->pixie->get_smstools_var('outgoing'),
            function ($fileName, $sign, $content) use (&$outMessages) {

                // header message to
                preg_match('/To:[\s](?<to>[\s\S]+?)\n/', $content, $matches);
                $to = trim($matches['to']);

                // header message text
                preg_match('/[\n]{1}(?<text>[\s\S]+)$/', $content, $matches);
                $text = trim($matches['text']);

                $outMessages[] = (object)array(
                    'id'        => $fileName,
                    'filename'  => $fileName,
                    'sign'      => $sign,
                    'to'        => $to,
                    'text'      => $text,
                    'timestamp' => (new \DateTime('now'))->getTimestamp()
                );
            }
        );

        $this->add_view_data('out_messages', $outMessages);
        $this->add_view_data('total_out_messages', sizeof($outMessages));
    }

    public function action_sync()
    {
        $curr_date = new \DateTime('now');
        $messages = $this->pixie->orm->get('turn')->order_by('timestamp', 'asc')->find_all();

        foreach($messages as $message) {
            $message_date = (new \DateTime('now'))->setTimestamp($message->of_timestamp);
            if ($curr_date >= $message_date) {
                $this->pixie->send_message($message->to, $message->text, $message->use_voice);
                $message->delete();
            }
        }

        $this->action_index();
    }
}
