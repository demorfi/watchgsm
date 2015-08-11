<?php

namespace App\Controller;

class Failed extends \App\Controller\App
{

    public function action_index()
    {
        $this->view->title = 'Failed';

        // remove sent messages
        if ($this->request->method == 'POST') {
            $failedPath = $this->pixie->get_smstools_var('failed');
            foreach ($this->request->post('messagesId', array()) as $messageId) {
                $failed = $this->pixie->orm->get('failed', $messageId);
                if ($failed->loaded()) {
                    $postData = $this->request->post();

                    // remove messages
                    if (isset($postData['delete'])) {
                        $this->pixie->remove_message_file($failedPath . DIRECTORY_SEPARATOR . $failed->filename);
                        $failed->delete();
                        $this->add_message_success('Messages removed!');
                    }

                    // send message again
                    if (isset($postData['send'])) {
                        $this->pixie->send_message($failed->to, $failed->text)
                            ? $this->add_message_success('Message sent to the queue for sending!')
                            : $this->add_message_error('Error while sending message!');
                    }
                }
            }
        }

        $failed = $this->pixie->orm->get('failed')->order_by('timestamp', 'asc');
        $this->add_view_data('messages', $failed->find_all());
        $this->add_view_data('total_messages', (int)$failed->count_all());
    }

    protected function sync()
    {
        $this->pixie->read_messages(
            $this->pixie->get_smstools_var('failed'),
            function ($fileName, $sign, $content) {
                $failed = $this->pixie->orm->get('failed')->where('sign', $sign)->find();
                if (!$failed->loaded()) {
                    $failed->sign     = $sign;
                    $failed->filename = $fileName;

                    // header message to
                    preg_match('/To:[\s](?<to>[\s\S]+?)\n/', $content, $matches);
                    $failed->to = trim($matches['to']);

                    // header message text
                    preg_match('/[\n]{2}(?<text>[\s\S]+)$/', $content, $matches);
                    $failed->text = trim($matches['text']);

                    // header fail reason
                    preg_match('/Fail_reason:[\s](?<reason>[\s\S]+?)\n/', $content, $matches);
                    $failed->reason = trim($matches['reason']);

                    // header message sent
                    preg_match('/Failed:[\s](?<failed>[\s\S]+?)\n/', $content, $matches);
                    $failed->timestamp = (new \DateTime(trim($matches['failed'])))->getTimestamp();

                    $failed->save();
                }
            }
        );
    }

}
