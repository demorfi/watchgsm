<?php

namespace App\Controller;

class Sent extends \App\Controller\App
{

    public function action_index()
    {
        $this->view->title = 'Sent';

        // remove sent messages
        if ($this->request->method == 'POST') {
            $sentPath = $this->pixie->get_smstools_var('sent');
            foreach ($this->request->post('messagesId') as $messageId) {
                $sent = $this->pixie->orm->get('sent', $messageId);
                if ($sent->loaded()) {
                    $this->pixie->remove_message_file($sentPath . DIRECTORY_SEPARATOR . $sent->filename);
                    $sent->delete();
                }
            }
            $this->add_message_success('Messages removed!');
        }

        $sent = $this->pixie->orm->get('sent')->order_by('timestamp', 'asc');
        $this->add_view_data('messages', $sent->find_all());
        $this->add_view_data('total_messages', (int)$sent->count_all());
    }

    protected function sync()
    {
        $sentPath = $this->pixie->get_smstools_var('sent');
        $this->pixie->read_messages(
            $sentPath,
            function ($fileName, $sign, $content) {
                $sent = $this->pixie->orm->get('sent')->where('sign', $sign)->find();
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
                    $date_time       = trim($matches['sent']);
                    $sent->timestamp = (new \DateTime($date_time, new \DateTimeZone('UTC')))->getTimestamp();

                    $sent->save();
                }
            }
        );
    }

}
