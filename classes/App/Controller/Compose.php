<?php

namespace App\Controller;

class Compose extends \App\Controller\App
{

    public function action_index()
    {
        $this->view->title = 'Compose New';

        if ($this->request->method == 'POST') {
            $postData = $this->request->post();

            // save message in templates
            if (isset($postData['save-template'])) {
                $template            = $this->pixie->orm->get('templates');
                $template->to        = $postData['number'];
                $template->text      = $postData['message'];
                $template->use_voice = isset($postData['use_voice']);
                $template->save();

                $this->add_message_success('Message saved in templates!');
            } else {

                // send message
                $this->pixie->send_message($postData['number'], $postData['message'], isset($postData['use_voice']))
                    ? $this->add_message_success('Message sent to the queue for sending!')
                    : $this->add_message_error('Error while sending message!');
            }
        }
    }

}
