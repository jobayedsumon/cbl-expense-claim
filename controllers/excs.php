<?php

require_once 'excs_common.php';

use http\Env\Request;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Excs extends Excs_Common
{

    public function advance_claim($claim_id = null)
    {
        if ($claim_id) {
            $data['claim_information'] = $this->edit_advance_claim($claim_id);
        } else {
            $claim_id = $this->create_new_advance_claim();
            redirect(base_url('excs/advance_claim/'.$claim_id));
        }

        $data['employee_information'] = $this->get_employee_information($data['claim_information']->claim->employee_id);
        $data['currency_list'] = $this->get_currency_list();
        $data['memo_references'] = $this->get_memo_references();
        $data['projects'] = $this->get_projects();
        $data['employee_list'] = $this->get_employee_list();
        $data['cost_center_list'] = $this->get_cost_center_list();
        $data['sol_list'] = $this->get_sol_list();
        $data['purpose_list'] = $this->get_purpose_list();

        $data['date_label'] = 'Claim Date';

        $level = $this->session->userdata('LEVEL_ID');
        if (empty($level)) {
            redirect(base_url('login_cont'));
        } else {
            $this->render_page('advance_claim_form', $data);
        }
    }

    public function travel_plan($plan_id = null)
    {
        if ($plan_id) {
            $data['travel_plan'] = $this->edit_travel_plan($plan_id);
        } else {
            $plan_id = $this->create_new_travel_plan();
            redirect(base_url('excs/travel_plan/'.$plan_id));
        }

        $data['employee_information'] = $this->get_employee_information($data['travel_plan']->plan->employee_id);
        $data['currency_list'] = $this->get_currency_list();
        $data['memo_references'] = $this->get_memo_references();
        $data['projects'] = $this->get_projects();
        $data['employee_list'] = $this->get_employee_list();
        $data['cost_center_list'] = $this->get_cost_center_list();
        $data['sol_list'] = $this->get_sol_list();
        $data['purpose_list'] = $this->get_purpose_list();
        $data['countries'] = $this->get_countries();

        $data['date_label'] = 'Request Date';

        $level = $this->session->userdata('LEVEL_ID');
        if (empty($level)) {
            redirect(base_url('login_cont'));
        } else {
            $this->render_page('travel_plan_form', $data);
        }
    }

    public function expense_claim($claim_id = null)
    {
        if ($claim_id) {
            $data['claim_information'] = $this->edit_expense_claim($claim_id);
        } else {
            $claim_id = $this->create_new_expense_claim();
            redirect(base_url('excs/expense_claim/'.$claim_id));
        }

        $data['employee_information'] = $this->get_employee_information($data['claim_information']->claim->employee_id);
        $data['currency_list'] = $this->get_currency_list();
        $data['memo_references'] = $this->get_memo_references();
        $data['advance_references'] = $this->get_advance_references();
        $data['projects'] = $this->get_projects();
        $data['employee_list'] = $this->get_employee_list();
        $data['cost_center_list'] = $this->get_cost_center_list();
        $data['sol_list'] = $this->get_sol_list();
        $data['purpose_list'] = $this->get_purpose_list();

        $data['date_label'] = 'Claim Date';

        $level = $this->session->userdata('LEVEL_ID');
        if (empty($level)) {
            redirect(base_url('login_cont'));
        } else {
            $this->render_page('expense_claim_form', $data);
        }
    }

    public function claim_list()
    {
        $data['title'] = 'Expense/Advance Claim List';
        $data['employee_list'] = $this->get_employee_list();
        $data['statuses'] = $this->get_statuses();
        $data['employee_information'] = $this->get_employee_information();

        $level = $this->session->userdata('LEVEL_ID');
        if (empty($level)) {
            redirect(base_url('login_cont'));
        } else {
            $this->render_page('claim_list', $data);
        }
    }

    public function claim_approval_list()
    {
        $data['title'] = 'Expense/Advance Claim Approval List';
        $data['employee_list'] = $this->get_employee_list();
        $data['statuses'] = $this->get_statuses();
        $data['employee_information'] = $this->get_employee_information();

        $level = $this->session->userdata('LEVEL_ID');
        if (empty($level)) {
            redirect(base_url('login_cont'));
        } else {
            $this->render_page('claim_approval_list', $data);
        }
    }

    public function view_claim($claim_id)
    {
        $data['claim_information'] = $this->get_claim_details($claim_id);
        $data['employee_information'] = $this->get_employee_information($data['claim_information']->claim->employee_id);
        $data['employee_list'] = $this->get_employee_list();
        $level = $this->session->userdata('LEVEL_ID');
        $data['level'] = $level;
        $data['approver_view'] = false;
        $data['admin_view'] = false;

        if ($this->input->get()) {
            if(array_key_exists('approver', $this->input->get())) {
                $data['approver_view'] = true;
            }
            if(array_key_exists('admin', $this->input->get())) {
                $data['admin_view'] = true;
            }
        }
        if (empty($level)) {
            redirect(base_url('login_cont'));
        } else {
            $this->render_page('claim_views/view_claim', $data);
        }
    }

    public function change_approval_person()
    {
        $data['title'] = 'Change Approval Person';
        $data['employee_list'] = $this->get_employee_list();
        $data['statuses'] = $this->get_statuses();
        $data['employee_information'] = $this->get_employee_information();
        $level = $this->session->userdata('LEVEL_ID');
        if (empty($level)) {
            redirect(base_url('login_cont'));
        } else {
            $this->render_page('change_approval_person', $data);
        }
    }


}
