<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CreateSalonTempo extends Auth_Controller {

        public function __construct()
        {
            parent::__construct();
            $this->load->database();
            $this->load->model('Salon_model');
        }

        public function create()
        {
            $this->data['rooms'] = $this->Salon_model->getSalon();
    		$this->data['nextRooms'] = $this->Salon_model->getSalon("next");
            $this->data['endedRooms'] = $this->Salon_model->getSalon("finished");
            $this->data['closedRooms'] = $this->Salon_model->getSalon("closed");

    		$this->form_validation->set_rules('name', 'nom du salon', 'required');
    		$this->form_validation->set_rules('start_date_day', 'jour d\'ouverture du salon', 'required');
            $this->form_validation->set_rules('start_date_hour','champs heure d\'ouverture du salon','required');
            $this->form_validation->set_rules('end_date_day','jour de fin du salon','required');
            $this->form_validation->set_rules('end_date_hour','champs heure de fin du salon','required');
            $this->form_validation->set_rules('id_livre','livre','required');
            $this->form_validation->set_rules('nb_max_report_needed','nombre de signalement maximal par utilisateur','required');

            if($this->form_validation->run() === FALSE) {
                $this->render('admin/salon/create', $this->data, null);
            } else {
                $start_date = $this->input->post('start_date_day') . " " . $this->input->post('start_date_hour');
                $end_date = $this->input->post('end_date_day') . " " . $this->input->post('end_date_hour');

                if($start_date <= date('Y-m-d H:i:s')) {
                    $statut = 1;
                } else {
                    $statut = 0;
                }

                $salon = new Salon_e(
                    0,
                    $this->input->post('name'),
                    $start_date,
                    $end_date,
                    $this->input->post('id_livre'),
                    $this->input->post('nb_max_user'),
                    $statut,
                    $this->input->post('nb_max_report_needed'),
                    0
                );
                $this->Salon_model->createSalon($salon);
                $this->data['success'] = "Le salon vient d'être crée";
                $this->render('admin/salon/create', $this->data, null);
            }
        }

        public function delete($id)
        {
            $this->Salon_model->delete($id);
            redirect('createsalontempo/create');
        }

        public function reopen($id)
        {
            $this->Salon_model->reopen($id);
            redirect('createsalontempo/create');
        }

        public function checkSalon()
        {
            $this->Salon_model->checkSalonStatut();
        }
}
