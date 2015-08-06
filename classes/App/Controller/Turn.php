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

                // header message sent
                preg_match('/Sent:[\s](?<sent>[\s\S]+?)\n/', $content, $matches);
                $date_time = trim($matches['sent']);
                $timestamp = (new \DateTime($date_time, new \DateTimeZone('UTC')))->getTimestamp();

                $outMessages[] = (object)array(
                    'id'        => -1,
                    'filename'  => $fileName,
                    'sign'      => $sign,
                    'to'        => $to,
                    'text'      => $text,
                    'timestamp' => $timestamp
                );
            }
        );

        $this->add_view_data('out_messages', $outMessages);
        $this->add_view_data('total_out_messages', sizeof($outMessages));
    }
}
