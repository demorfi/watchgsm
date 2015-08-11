<?php

namespace App\Controller;

class Inbox extends \App\Controller\App
{

    public function action_index()
    {
        $this->view->title = 'Inbox';

        // remove inbox messages
        if ($this->request->method == 'POST') {
            $inboxPath = $this->pixie->get_smstools_var('incoming');
            foreach ($this->request->post('messagesId', array()) as $messageId) {
                $inbox = $this->pixie->orm->get('inbox', $messageId);
                if ($inbox->loaded()) {
                    $this->pixie->remove_message_file($inboxPath . DIRECTORY_SEPARATOR . $inbox->filename);
                    $inbox->delete();
                }
            }
            $this->add_message_success('Messages removed!');
        }

        $inbox = $this->pixie->orm->get('inbox')->order_by('timestamp', 'asc');
        $this->add_view_data('messages', $inbox->find_all());
        $this->add_view_data('total_messages', (int)$inbox->count_all());
    }

    protected function sync()
    {
        $inboxPath = $this->pixie->get_smstools_var('incoming');
        $this->pixie->read_messages(
            $inboxPath,
            function ($fileName, $sign, $content) {
                $inbox = $this->pixie->orm->get('inbox')->where('sign', $sign)->find();
                if (!$inbox->loaded()) {
                    $inbox->sign     = $sign;
                    $inbox->filename = $fileName;

                    // header message from
                    preg_match('/From:[\s](?<from>[\s\S]+?)\n/', $content, $matches);
                    $inbox->from = trim($matches['from']);

                    // header message text
                    preg_match('/[\n]{2}(?<text>[\s\S]+)$/', $content, $matches);
                    $inbox->text = trim($matches['text']);

                    // header message sent
                    preg_match('/Received:[\s](?<received>[\s\S]+?)\n/', $content, $matches);
                    $inbox->timestamp = (new \DateTime(trim($matches['received'])))->getTimestamp();

                    $inbox->save();
                }
            }
        );
    }

}
