<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getDefaultBranch()
    {
        $school = "";
        if ($this->uri->segment(4)) {
            $school = $this->uri->segment(4);
        } else {
            $school = $this->uri->segment(3);
        }
        $row = $this->db->select('branch_id')->get_where('front_cms_setting', array('url_alias' => $school))->row_array();
        if (empty($row) || $row['branch_id'] == 0) {
            $row = $this->db->where('id',1)->get('global_settings')->row_array();
            return $row['cms_default_branch'];
        } else {
            return $row['branch_id'];
        }
    }

    public function get_teacher_list($start = '', $branch_id)
    {
        $this->db->select('staff.*,staff_designation.name as designation_name,staff_department.name as department_name');
        $this->db->from('staff');
        $this->db->join('login_credential', 'login_credential.user_id = staff.id and login_credential.role != 7', 'inner');
        $this->db->join('staff_designation', 'staff_designation.id = staff.designation', 'left');
        $this->db->join('staff_department', 'staff_department.id = staff.department', 'left');
        $this->db->where('login_credential.role', 3);
        $this->db->where('login_credential.active', 1);
        $this->db->where('staff.branch_id', $branch_id);
        $this->db->order_by('staff.id', 'asc');
        if ($start != '') {
            $this->db->limit(4, $start);
        }
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_teacher_departments($branch_id)
    {
        $this->db->select('staff_department.id as department_id,staff_department.name as department_name');
        $this->db->from('staff_department');
        $this->db->join('staff', 'staff.department = staff_department.id', 'left');
        $this->db->join('login_credential', 'login_credential.user_id = staff.id and login_credential.role != 7', 'inner');
        $this->db->where('login_credential.role', 3);
        $this->db->where('login_credential.active', 1);
        $this->db->where('staff_department.branch_id', $branch_id);
        $this->db->group_by('staff_department.id');
        $this->db->order_by('staff.id', 'asc');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function branch_list() 
    {
        $this->db->select('b.school_name,b.id');
        $this->db->from('branch as b');
        $this->db->join('front_cms_setting as f', 'f.branch_id = b.id', 'inner');
        $this->db->where('f.cms_active', 1);
        $result = $this->db->get()->result();
        $arrayData = array();
        foreach ($result as $row) {
            $arrayData[$row->id] = $row->school_name;
        }
        return $arrayData;
    }

    function menuList($school = '', $branchID = '')
    {
        $mainMenu = array();
        $subMenu = array();
        $mergeMenu = array();
        if (empty($branchID)) {
            $branchID = $this->getDefaultBranch();
        }
        $this->db->select('front_cms_menu.*,if(mv.name is null, front_cms_menu.title, mv.name) as title,if(mv.parent_id is null, front_cms_menu.parent_id, mv.parent_id) as parent_id,if(mv.ordering is null, front_cms_menu.ordering, mv.ordering) as ordering,mv.invisible');
        $this->db->from('front_cms_menu');
        $this->db->join('front_cms_menu_visible as mv', 'mv.menu_id = front_cms_menu.id and mv.branch_id = ' . $branchID, 'left');
        $this->db->where('front_cms_menu.publish', 1);
        $this->db->where_in('front_cms_menu.branch_id', array(0, $branchID));
        $result = $this->db->get()->result_array();
        //php array sort
        array_multisort(array_column($result, 'ordering'), SORT_ASC, SORT_NUMERIC, $result);
        foreach ($result as $key => $value) {
            if ($value['invisible'] == 0) {
                if ($value['parent_id'] == 0) {
                    $mainMenu[$key] = $value;
                } else {
                    $subMenu[$key] = $value;
                }
            }
        }

        foreach ($mainMenu as $key => $value) {
            $mergeMenu[$key] = $value;
            $mergeMenu[$key]['url'] = $this->genURL($value, $school);
            foreach ($subMenu as $key2 => $value2) {
                if ($value['id'] == $value2['parent_id']) {
                    $mergeMenu[$key]['submenu'][$key2] = array(
                        'title' => $value2['title'],
                        'open_new_tab' => $value2['open_new_tab'],
                        'url' => $this->genURL($value2, $school)
                    );
                }
            }
        }

        return $mergeMenu;
    }

    function genURL($array = array(), $school = '')
    {
        $url = "#";
        if ($school != '')
            $school = '/' .  $school;
        if ($array['system'] && $array['alias'] !== 'pages') {
            $url = base_url('home/' . $array['alias'] . $school);
        } else {
            if ($array['ext_url']) {
                $url = $array['ext_url_address'];
            } else {
                $url = base_url('home/page/' . $array['alias'] . $school);
            }
        }
        return $url;
    }

    function getExamList($branchID = '', $classID = '', $sectionID = '')
    {
        $sessionID = get_session_id();
        $this->db->select('exam.id,exam.name,exam.term_id');
        $this->db->from('timetable_exam');
        $this->db->join('exam','exam.id = timetable_exam.exam_id', 'left');
        if (!empty($classID))
            $this->db->where('timetable_exam.class_id', $classID);
        if (!empty($sectionID))
            $this->db->where('timetable_exam.section_id', $sectionID);
        $this->db->where('timetable_exam.branch_id', $branchID);
        $this->db->where('timetable_exam.session_id', $sessionID);
        $this->db->group_by('timetable_exam.exam_id');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function getGalleryCategory($branch_id)
    {
        $this->db->select('front_cms_gallery_category.id as category_id,front_cms_gallery_category.name as category_name');
        $this->db->from('front_cms_gallery_category');
        $this->db->join('front_cms_gallery_content', 'front_cms_gallery_content.category_id = front_cms_gallery_category.id', 'inner');
        $this->db->where('front_cms_gallery_category.branch_id', $branch_id);
        $this->db->group_by('front_cms_gallery_category.id');
        $this->db->where('front_cms_gallery_content.show_web', 1);
        $this->db->order_by('front_cms_gallery_category.id', 'asc');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function getGalleryList($branch_id)
    {
        $this->db->select('front_cms_gallery_content.*,staff.name as staff_name');
        $this->db->from('front_cms_gallery_content');
        $this->db->join('staff', 'staff.id = front_cms_gallery_content.added_by', 'left');
        $this->db->where('front_cms_gallery_content.branch_id', $branch_id);
        $this->db->where('front_cms_gallery_content.show_web', 1);
        $this->db->order_by('front_cms_gallery_content.id', 'asc');
        $result = $this->db->get()->result_array();
        return $result;
    }
}
