<?php

namespace App\Controller;

class Events extends \App\Controller\App
{

    public function action_index()
    {
        $this->view->title = 'Events';

        if ($this->request->method == 'POST') {
            foreach ($this->request->post('eventsId', array()) as $eventId) {
                $event = $this->pixie->orm->get('events', $eventId);
                if ($event->loaded()) {
                    $event->delete();
                    $this->add_message_success('Events removed!');
                }
            }
        }

        $events = $this->pixie->orm->get('events');
        $this->add_view_data('events', $events->find_all());
        $this->add_view_data('total_events', (int)$events->count_all());
    }

    public function action_add()
    {
        $this->view->title = 'Add Event';

        if ($this->request->method == 'POST') {
            $postData = $this->request->post('event');
            if (empty($postData)) {
                $this->add_message_error('Unable to add a new event!');
                return;
            }

            $this->pixie->orm->get('events')->values($postData)->save();
            $this->add_message_success('A new event has been added!', true);
            $this->response->redirect(
                $this->pixie->router->get('default')->url(
                    array('controller' => 'events')
                )
            );
        }
    }

    public function action_edit()
    {
        $this->view->title = 'Edit Event';

        $event = $this->pixie->orm->get('events', $this->request->param('id'));
        if (!$event->loaded()) {
            $this->add_message_success('The requested event was not found!', true);
            $this->response->redirect(
                $this->pixie->router->get('default')->url(
                    array('controller' => 'events')
                )
            );
            return;
        }

        if ($this->request->method == 'POST') {
            $postData = $this->request->post('event');
            if (empty($postData)) {
                $this->add_message_error('Unable to save a event!');
                return;
            }

            $event->values($postData)->save();
            $this->add_message_success('A event has been saved!', true);
            $this->response->redirect(
                $this->pixie->router->get('default')->url(
                    array('controller' => 'events')
                )
            );
            return;
        }

        $this->add_view_data('event', $event);
    }
}
