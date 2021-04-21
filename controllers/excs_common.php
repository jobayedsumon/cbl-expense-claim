<?php

/*
 *
 * CLAIM_TYPE           IDENTIFIER
 *
 * Advance              1
 * Expense              2
 *
 *
 */

use http\Env\Request;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Excs_Common extends Custom_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('excs', 'url'));
    }

    public function create_new_advance_claim()
    {
        $params = array(
            'CREATED_BY' => $this->user->EMPLOYEE_ID,
            'EMPLOYEE_ID' => $this->user->EMPLOYEE_ID,
            'CLAIM_TYPE' => 1 //For advance type claim
        );
        $data = json_encode($params);
        $ch = curl_init();
        $url = excs_url().'/excs/claims/store';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        $new_advance_claim = json_decode($server_output);

        if ($new_advance_claim) {
            return $new_advance_claim->data->claim->exc_claim_requests_id;

        } else {
            exit('Couldn\'t create new request!');
        }
    }

    public function edit_advance_claim($claim_id)
    {
        $ch = curl_init();
        $url = excs_url().'/excs/claims/edit/'.$claim_id;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        $edit_advance_claim = json_decode($server_output);

        if ($edit_advance_claim) {
            return $edit_advance_claim->data;

        } else {
            exit('Couldn\'t create existing request!');
        }
    }

    public function create_new_travel_plan()
    {
        $params = array(
            'CREATED_BY' => $this->user->EMPLOYEE_ID,
            'EMPLOYEE_ID' => $this->user->EMPLOYEE_ID,
        );
        $data = json_encode($params);
        $ch = curl_init();
        $url = excs_url().'/excs/travel_plans';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        $new_travel_plan = json_decode($server_output);

        if ($new_travel_plan) {
            return $new_travel_plan->data->plan->exc_travel_plans_id;

        } else {
            exit('Couldn\'t create new request!');
        }
    }

    public function edit_travel_plan($plan_id)
    {
        $ch = curl_init();
        $url = excs_url().'/excs/travel_plans/'.$plan_id.'/edit';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        $edit_travel_plan = json_decode($server_output);

        if ($edit_travel_plan) {
            return $edit_travel_plan->data;

        } else {
            exit('Couldn\'t create existing request!');
        }
    }

    public function create_new_expense_claim()
    {
        $params = array(
            'CREATED_BY' => $this->user->EMPLOYEE_ID,
            'EMPLOYEE_ID' => $this->user->EMPLOYEE_ID,
            'CLAIM_TYPE' => 2 //For expense type claim
        );
        $data = json_encode($params);
        $ch = curl_init();
        $url = excs_url().'/excs/claims/store';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        $new_expense_claim = json_decode($server_output);

        if ($new_expense_claim) {
            return $new_expense_claim->data->claim->exc_claim_requests_id;

        } else {
            exit('Couldn\'t create new request!');
        }
    }

    public function edit_expense_claim($claim_id)
    {
        $ch = curl_init();
        $url = excs_url().'/excs/claims/edit/'.$claim_id;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        $edit_expense_claim = json_decode($server_output);

        if ($edit_expense_claim) {
            return $edit_expense_claim->data;

        } else {
            exit('Couldn\'t create existing request!');
        }
    }

    public function advance_information_store()
    {

        $data = json_encode($this->input->post());

        $url = excs_url().'/excs/claim_details';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            $data);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close ($ch);

        echo $server_output;
    }

    public function expense_information_store()
    {
        $data = json_encode($this->input->post());

        $url = excs_url().'/excs/claim_details';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            $data);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close ($ch);

        echo $server_output;
    }

    public function advance_claim_store()
    {
        $data = json_encode($this->input->post());

        echo $data;

        $url = excs_url().'/excs/claims/update';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            $data);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close ($ch);

        echo $server_output;
    }

    public function expense_claim_store()
    {
        echo json_encode($this->input->post());
    }

    /****************************************
     *
     * COMMON DATA FETCHING
     ***************************************
     * @param null $employee_id
     * @return mixed
     */

    public function get_employee_information($employee_id = null)
    {
        if (!$employee_id) {
            $employee_id = $this->user->EMPLOYEE_ID;
        }

        $params = array('EMPLOYEE_ID' => $employee_id);
        $data = json_encode($params);
        $ch = curl_init();
        $url = excs_url().'/employee';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        $employee_information = json_decode($server_output);

        if ($employee_information) {
            return $employee_information->data->employee;
        }

    }

    public function get_currency_list() {

        $ch = curl_init();
        $url = excs_url().'/currencies';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        $currency_list = json_decode($server_output);

        if ($currency_list) {
            return $currency_list->data->currencies;
        }

    }

    public function get_memo_references()
    {

        if (!$this->input->post('employeeId')) {

            $params = array('EMPLOYEE_ID' => $this->user->EMPLOYEE_ID);
            $data = json_encode($params);
            $ch = curl_init();
            $url = excs_url().'/memos';

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close($ch);

            $memo_references = json_decode($server_output);

            if ($memo_references) {
                return $memo_references->data->memos;
            }

        }
        else {

            $params = array('EMPLOYEE_ID' => $this->input->post('employeeId'));
            $data = json_encode($params);
            $ch = curl_init();
            $url = excs_url().'/memos';

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close($ch);

            echo $server_output;

        }
    }

    public function get_advance_references()
    {

        if (!$this->input->post('employeeId')) {

            $params = array('EMPLOYEE_ID' => $this->user->EMPLOYEE_ID);
            $data = json_encode($params);
            $ch = curl_init();
            $url = excs_url().'/excs/claims/advances';

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close($ch);

            $advance_references = json_decode($server_output);

            if ($advance_references) {
                return $advance_references->data->advances;
            }

        }
        else {

            $params = array('EMPLOYEE_ID' => $this->input->post('employeeId'));
            $data = json_encode($params);
            $ch = curl_init();
            $url = excs_url().'/advances';

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close($ch);

            echo $server_output;

        }
    }

    public function get_projects() {

        $ch = curl_init();
        $url = excs_url().'/projects';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        $projects = json_decode($server_output);

        if ($projects) {
            return $projects->data->projects;
        }
    }

    public function get_cost_center_list() {

        $ch = curl_init();
        $url = excs_url().'/cost_centers';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        $cost_center_list = json_decode($server_output);

        if ($cost_center_list) {
            return $cost_center_list->data->cost_centers;
        }
    }

    public function get_sol_list() {

        $ch = curl_init();
        $url = excs_url().'/sols';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        $sol_list = json_decode($server_output);

        if ($sol_list) {
            return $sol_list->data->sols;
        }
    }

    public function get_employee_list()
    {
        $ch = curl_init();
        $url = excs_url().'/employees';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        $employee_list = json_decode($server_output);

        if ($employee_list) {
            return $employee_list->data->employees;
        }
    }

    public function get_countries()
    {
        $ch = curl_init();
        $url = excs_url().'/countries';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        $countries = json_decode($server_output);

        if ($countries) {
            return $countries->data->countries;
        }
    }

    public function purpose()
    {
        $data['gl_account_list'] = $this->get_gl_account_list();
        $data['purpose_list'] = $this->get_purpose_list();
        $level = $this->session->userdata('LEVEL_ID');
        if (empty($level)) {
            redirect(base_url('login_cont'));
        } else {
            $this->render_page('purpose', $data);
        }
    }

    public function get_gl_account_list()
    {
        $ch = curl_init();
        $url = excs_url().'/gl_accounts';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        $gl_account_list = json_decode($server_output);

        if ($gl_account_list) {
            return $gl_account_list->data->gl_accounts;
        }
    }

    public function get_purpose_list()
    {
        $ch = curl_init();
        $url = excs_url().'/excs/purposes';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        $purpose_list = json_decode($server_output);

        if ($purpose_list) {
            return $purpose_list->data->purposes;
        }
    }

    public function get_statuses()
    {
        $ch = curl_init();
        $url = excs_url().'/excs/statuses';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        $statuses = json_decode($server_output);

        if ($statuses) {
            return $statuses->data->statuses;
        }
    }

    public function get_claim_details($claim_id)
    {
        $ch = curl_init();
        $url = excs_url().'/excs/claims/'.$claim_id;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        $statuses = json_decode($server_output);

        if ($statuses) {
            return $statuses->data;
        }
    }

}
