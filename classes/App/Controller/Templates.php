<?php

namespace App\Controller;

class Templates extends \App\Controller\App
{

    public function action_index()
    {
        $this->view->title = 'SMS Templates';

        if ($this->request->method == 'POST') {
            foreach ($this->request->post('templatesId') as $templateId) {
                $template = $this->pixie->orm->get('templates', $templateId);
                if ($template->loaded()) {
                    $postData = $this->request->post();

                    // remove templates messages
                    if (isset($postData['delete'])) {
                        $template->delete();
                        $this->add_message_success('Templates removed!');
                    }

                    // send message from template
                    if (isset($postData['send'])) {
                        $this->pixie->send_message($template->to, $template->text)
                            ? $this->add_message_success('Message sent to the queue for sending!')
                            : $this->add_message_error('Error while sending message!');
                    }
                }
            }
        }

        $templates = $this->pixie->orm->get('templates');
        $this->add_view_data('templates', $templates->find_all());
        $this->add_view_data('total_templates', (int)$templates->count_all());
    }

}
