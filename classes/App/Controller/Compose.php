<?php

namespace App\Controller;

class Compose extends \App\Controller\App
{

    public function action_index()
    {
        $this->view->title = 'Compose New SMS';

        if ($this->request->method == 'POST') {
            $postData = $this->request->post();

            // save message in templates
            if (isset($postData['save-template'])) {
                $template       = $this->pixie->orm->get('templates');
                $template->to   = $postData['number'];
                $template->text = $postData['message'];
                $template->save();

                $this->add_message_success('Message saved in templates!');
            } else {

                // send message
                $this->pixie->send_message($postData['number'], $postData['message'])
                    ? $this->add_message_success('Message sent to the queue for sending!')
                    : $this->add_message_error('Error while sending message!');
            }
        }
    }

}
