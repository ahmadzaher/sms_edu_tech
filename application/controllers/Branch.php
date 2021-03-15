<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @package : Ramom school management system
 * @version : 3.0
 * @developed by : RamomCoder
 * @support : ramomcoder@yahoo.com
 * @author url : http://codecanyon.net/user/RamomCoder
 * @filename : Accounting.php
 * @copyright : Reserved RamomCoder Team
 */

class Branch extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('branch_model');
    }

    /* branch all data are prepared and stored in the database here */
    public function index()
    {
        if (is_superadmin_loggedin()) {
            if ($this->input->post('submit') == 'save') {
                $this->form_validation->set_rules('branch_name', translate('branch_name'), 'required|callback_unique_name');
                $this->form_validation->set_rules('school_name', translate('school_name'), 'required');
                $this->form_validation->set_rules('email', translate('email'), 'required|valid_email');
                $this->form_validation->set_rules('mobileno', translate('mobile_no'), 'required');
                $this->form_validation->set_rules('currency', translate('currency'), 'required');
                $this->form_validation->set_rules('currency_symbol', translate('currency_symbol'), 'required');
                if ($this->form_validation->run() == true) {
                    $post = $this->input->post();
                    $response = $this->branch_model->save($post);
                    if ($response) {
                        set_alert('success', translate('information_has_been_saved_successfully'));
                    }
                    redirect(base_url('branch'));
                } else {
                    $this->data['validation_error'] = true;
                }
            }
            $this->data['title'] = translate('branch');
            $this->data['sub_page'] = 'branch/add';
            $this->data['main_menu'] = 'branch';
            $this->load->view('layout/index', $this->data);
        } else {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
    }

    /* branch information update here */
    public function edit($id = '')
    {
        if (is_superadmin_loggedin()) {
            if ($this->input->post('submit') == 'save') {
                $this->form_validation->set_rules('branch_name', translate('branch_name'), 'required|callback_unique_name');
                $this->form_validation->set_rules('school_name', translate('school_name'), 'required');
                $this->form_validation->set_rules('email', translate('email'), 'required|valid_email');
                $this->form_validation->set_rules('mobileno', translate('mobile_no'), 'required');
                $this->form_validation->set_rules('currency', translate('currency'), 'required');
                $this->form_validation->set_rules('currency_symbol', translate('currency_symbol'), 'required');
                if ($this->form_validation->run() == true) {
                    $post = $this->input->post();
                    $response = $this->branch_model->save($post, $id);
                    if ($response) {
                        set_alert('success', translate('information_has_been_updated_successfully'));
                    }
                    redirect(base_url('branch'));
                }
            }

            $this->data['data'] = $this->branch_model->getSingle('branch', $id, true);
            $this->data['title'] = translate('branch');
            $this->data['sub_page'] = 'branch/edit';
            $this->data['main_menu'] = 'branch';
            $this->load->view('layout/index', $this->data);
        } else {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
    }

    /* delete information */
    public function delete_data($id = '')
    {
        if (is_superadmin_loggedin()) {
            $this->db->where('id', $id);
            $this->db->delete('branch');

            $this->db->where('branch_id', $id);
            $this->db->delete('accounts');

            $this->db->where('branch_id', $id);
            $this->db->delete('advance_salary');

            $this->db->where('branch_id', $id);
            $this->db->delete('attachments');

            $this->db->where('branch_id', $id);
            $this->db->delete('attachments_type');

            $this->db->where('branch_id', $id);
            $this->db->delete('award');

            $this->db->where('branch_id', $id);
            $this->db->delete('book');

            $this->db->where('branch_id', $id);
            $this->db->delete('book_category');

            $this->db->where('branch_id', $id);
            $this->db->delete('award');

            $this->db->where('branch_id', $id);
            $this->db->delete('book_issues');

            $this->db->where('branch_id', $id);
            $this->db->delete('bulk_msg_category');

            $this->db->where('branch_id', $id);
            $this->db->delete('bulk_sms_email');

            $this->db->where('branch_id', $id);
            $this->db->delete('card_templete');

            $this->db->where('branch_id', $id);
            $this->db->delete('	certificates_templete');

            $this->db->where('branch_id', $id);
            $this->db->delete('class');

            $this->db->where('branch_id', $id);
            $this->db->delete('custom_field');

            $this->db->where('branch_id', $id);
            $this->db->delete('email_config');

            $this->db->where('branch_id', $id);
            $this->db->delete('email_templates_details');

            $this->db->where('branch_id', $id);
            $this->db->delete('enroll');

            $this->db->where('branch_id', $id);
            $this->db->delete('event');

            $this->db->where('branch_id', $id);
            $this->db->delete('event_types');

            $this->db->where('branch_id', $id);
            $this->db->delete('exam');

            $this->db->where('branch_id', $id);
            $this->db->delete('exam_attendance');

            $this->db->where('branch_id', $id);
            $this->db->delete('exam_hall');

            $this->db->where('branch_id', $id);
            $this->db->delete('exam_mark_distribution');

            $this->db->where('branch_id', $id);
            $this->db->delete('exam_term');

            $this->db->where('branch_id', $id);
            $this->db->delete('fees_reminder');

            $this->db->where('branch_id', $id);
            $this->db->delete('fees_type');

            $this->db->where('branch_id', $id);
            $this->db->delete('fee_allocation');

            $this->db->where('branch_id', $id);
            $this->db->delete('fee_fine');

            $this->db->where('branch_id', $id);
            $this->db->delete('fee_groups');

            $this->db->where('branch_id', $id);
            $this->db->delete('front_cms_about');

            $this->db->where('branch_id', $id);
            $this->db->delete('front_cms_admission');

            $this->db->where('branch_id', $id);
            $this->db->delete('front_cms_contact');

            $this->db->where('branch_id', $id);
            $this->db->delete('	front_cms_events');

            $this->db->where('branch_id', $id);
            $this->db->delete('front_cms_faq');

            $this->db->where('branch_id', $id);
            $this->db->delete('front_cms_faq_list');

            $this->db->where('branch_id', $id);
            $this->db->delete('front_cms_home');

            $this->db->where('branch_id', $id);
            $this->db->delete('front_cms_home_seo');

            $this->db->where('branch_id', $id);
            $this->db->delete('front_cms_menu');

            $this->db->where('branch_id', $id);
            $this->db->delete('front_cms_pages');

            $this->db->where('branch_id', $id);
            $this->db->delete('front_cms_services');

            $this->db->where('branch_id', $id);
            $this->db->delete('front_cms_services_list');

            $this->db->where('branch_id', $id);
            $this->db->delete('front_cms_setting');

            $this->db->where('branch_id', $id);
            $this->db->delete('front_cms_teachers');

            $this->db->where('branch_id', $id);
            $this->db->delete('front_cms_testimonial');

            $this->db->where('branch_id', $id);
            $this->db->delete('grade');

            $this->db->where('branch_id', $id);
            $this->db->delete('hall_allocation');

            $this->db->where('branch_id', $id);
            $this->db->delete('homework');

            $this->db->where('branch_id', $id);
            $this->db->delete('hostel');

            $this->db->where('branch_id', $id);
            $this->db->delete('hostel_category');

            $this->db->where('branch_id', $id);
            $this->db->delete('hostel_room');

            $this->db->where('branch_id', $id);
            $this->db->delete('leave_application');

            $this->db->where('branch_id', $id);
            $this->db->delete('leave_category');

            $this->db->where('branch_id', $id);
            $this->db->delete('live_class');

            $this->db->where('branch_id', $id);
            $this->db->delete('live_class_config');

            $this->db->where('branch_id', $id);
            $this->db->delete('mark');

            $this->db->where('branch_id', $id);
            $this->db->delete('online_admission');

            $this->db->where('branch_id', $id);
            $this->db->delete('parent');

            $this->db->where('branch_id', $id);
            $this->db->delete('payment_config');

            $this->db->where('branch_id', $id);
            $this->db->delete('payment_types');

            $this->db->where('branch_id', $id);
            $this->db->delete('payslip');

            $this->db->where('branch_id', $id);
            $this->db->delete('salary_template');

            $this->db->where('branch_id', $id);
            $this->db->delete('section');

            $this->db->where('branch_id', $id);
            $this->db->delete('	semysms_config');

            $this->db->where('branch_id', $id);
            $this->db->delete('	staff');

            $this->db->where('branch_id', $id);
            $this->db->delete('staff_attendance');

            $this->db->where('branch_id', $id);
            $this->db->delete('staff_department');

            $this->db->where('branch_id', $id);
            $this->db->delete('staff_designation');

            $this->db->where('branch_id', $id);
            $student_category_id = '';
            $student_category = $this->db->get('student_category')->row_array();
            if(!empty($student_category))
                $student_category_id = $student_category['id'];

            $this->db->where('branch_id', $id);
            $this->db->delete('student_category');

            $this->db->where('category_id', $student_category_id);
            $this->db->delete('student');

            $this->db->where('branch_id', $id);
            $this->db->delete('student_attendance');

            $this->db->where('branch_id', $id);
            $this->db->delete('student_category');

            $this->db->where('branch_id', $id);
            $this->db->delete('subject');

            $this->db->where('branch_id', $id);
            $this->db->delete('subject_assign');

            $this->db->where('branch_id', $id);
            $this->db->delete('teacher_allocation');

            $this->db->where('branch_id', $id);
            $this->db->delete('teacher_note');

            $this->db->where('branch_id', $id);
            $this->db->delete('timetable_class');

            $this->db->where('branch_id', $id);
            $this->db->delete('timetable_exam');

            $this->db->where('branch_id', $id);
            $this->db->delete('transactions');

            $this->db->where('branch_id', $id);
            $this->db->delete('transactions_links');

            $this->db->where('branch_id', $id);
            $this->db->delete('transport_assign');

            $this->db->where('branch_id', $id);
            $this->db->delete('transport_route');

            $this->db->where('branch_id', $id);
            $this->db->delete('transport_stoppage');

            $this->db->where('branch_id', $id);
            $this->db->delete('transport_vehicle');

            $this->db->where('branch_id', $id);
            $this->db->delete('voucher_head');

        } else {
            redirect(base_url(), 'refresh');
        }
    }

    /* unique valid branch name verification is done here */
    public function unique_name($name)
    {
        $branch_id = $this->input->post('branch_id');
        if (!empty($branch_id)) {
            $this->db->where_not_in('id', $branch_id);
        }
        $this->db->where('name', $name);
        $name = $this->db->get('branch')->num_rows();
        if ($name == 0) {
            return true;
        } else {
            $this->form_validation->set_message("unique_name", translate('already_taken'));
            return false;
        }
    }
}
