<?php

namespace App\Http\Controllers\SupportTeam;

use App\Exports\ExportMetalist;
use App\Exports\Exportclasslist;
use App\Exports\ExportCustomExcel;
use App\Helpers\Qs;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepo;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Repositories\MessageRepo;
use App\Models\Exam;
use App\Models\ClassType;
use App\Models\Grade;
use App\Models\metalist;
use App\Models\Form;
use App\Models\MyClass;
use App\Repositories\ExamRepo;
use Illuminate\Http\Request;
use App\Repositories\MyClassRepo;
use Symfony\Component\VarDumper\VarDumper;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use File;
use PDF;

class PrintOutsController extends Controller
{
    protected $exam;
    protected $user;
    protected  $message_repo;
    protected  $my_class;
    public function __construct(UserRepo $user, MessageRepo $message_repo, ExamRepo $exam, MyClassRepo $my_class)
    {
        $this->user = $user;
        $this->exam = $exam;
        $this->my_class = $my_class;
        $this->middleware('teamSA', ['except' => ['verify', 'enter_pin']]);
        $this->message_repo = $message_repo;
    }

    public function index()
    {
        $d['user'] = $this->user;
        $d['schoolname'] = $this->user->getschoolname();
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        $d['exams'] = $this->exam->all();
        $this->user->updateZero();
        $d['form'] = $this->exam->get_all_form();
        $d['subjects'] = $this->exam->get_all_form();
        return view('pages.support_team.printouts.index', $d);
    }

    public function get_stream_value_by_form(Request $req)
    {
        $form_id = $req['form_id'];
        $data['streams'] = $this->my_class->find_stream_by_formID($form_id);
        return json_encode(["streams" => $data['streams']]);
    }

    public function check_student_id($arr1, $id)
    {
        foreach ($arr1 as $val) {
            if ($val == $id) {
                return false;
            }
        }
        return true;
    }


    public function check_subject_id($arr1, $id)
    {
        foreach ($arr1 as $val) {
            if ($val == $id) {
                return false;
            }
        }
        return true;
    }

    public function get_meta_list(Request $req)
    {
        $stream_id = $req['stream_id'];
        $form_id = $req['form_id'];
        $exam_id = $req['exam_id'];
        $exam_name = $this->exam->get_exam_by_id($exam_id);
        $form_name = $this->exam->get_form_by_id($form_id);
        $stream_name_by_id = $this->exam->get_stream_by_id($stream_id);
        $previous_exam_id =  $exam_id - 1;
        $student_arr = [];
        $previous_arr = [];
        $data['metalist'] = $this->my_class->get_userlist_from_exam_record($stream_id, $exam_id);
        $data['pre_metalist'] = $this->my_class->get_userlist_from_exam_record($stream_id, $previous_exam_id);
        if (count($this->my_class->get_userlist_from_exam_record($stream_id, $previous_exam_id)) > 0) {
            $previous_arr = $this->get_each_student_marks($data['pre_metalist'], $form_id, $exam_id);
        }
        $student_arr = $this->get_each_student_marks($data['metalist'], $form_id, $exam_id);
        $data['subjectlist'] = $this->my_class->get_subject_list($stream_id);

        ///////////////////////////////////////////////////////////////////////////////////////////////////
        $second_table = [];
        $form_stream = $this->my_class->getformstream($form_id);
        $i = 0;
        foreach ($form_stream as $key => $val) {
            $second_table[$i] = [];
            $my_class_id = $val->id;
            $empty_arr = [];
            $exam_records = $this->exam->exam_records($exam_id, $my_class_id);
            $totalmark = 0;
            $overgradingsys = $exam_records[0]->overal_grading_sys;
            $grades = $this->exam->get_grades($overgradingsys);
            $stream_name =  $val->stream;
            // empty array
            foreach ($exam_records  as $val) {
                if (!$this->check_student_id($empty_arr, $val->student_id)) {
                    continue;
                } else {
                    array_push($empty_arr, $val->student_id);
                }
            }

            // empty array
            $total_mark = 0;
            $overal_grading_sys = [];
            $grade_names = [];
            $total_remark = 0;
            foreach ($empty_arr as $key => $val) {
                $str = "";
                $total_mark_per_student = 0;
                $mean_mark_per_student = 0;
                $grade_name_per_student = '';
                foreach ($exam_records as $value) {
                    if ($val == $value->student_id) {
                        $str = $str . $value->pos . ",";
                        $overal_grading_sys = $value->class_type->grades;
                    }
                }
                $str = substr($str, 0, (strlen($str) - 1));
                $mark_arr = explode(",", $str);

                foreach ($mark_arr as $mark_val) {
                    $total_mark_per_student += (int)$mark_val;
                }
                $mean_mark_per_student = round($total_mark_per_student / count($mark_arr), 2);
                $total_mark +=  $mean_mark_per_student;
                $remark = '';
                foreach ($overal_grading_sys as  $grade_val) {
                    if ($mean_mark_per_student >= $grade_val->mark_from && $mean_mark_per_student <= $grade_val->mark_to) {
                        $grade_name_per_student = $grade_val->name;
                        $remark = $grade_val->remark;
                    }
                }
                $total_remark += $remark;
                array_push($grade_names, $grade_name_per_student);
            }


            $mean_mark = round($total_mark / count($empty_arr), 2);
            $grade_name = '';

            foreach ($overal_grading_sys as  $grade_val) {
                if ($mean_mark >= $grade_val->mark_from && $mean_mark <= $grade_val->mark_to) {
                    $grade_name = $grade_val->name;
                }
            }

            $mean_remark =  round($total_remark / count($empty_arr), 2);
            $entry = count($empty_arr);
            array_push($second_table[$i], $stream_name, $entry, $mean_mark, $grade_name, $grade_names, $mean_remark);

            $i++;
        }
        //second_table end

        //third_table start
        $third_table = [];
        $user_list_by_stream = $this->my_class->get_userlist_from_exam_record($stream_id, $exam_id);
        $i = 0;
        $empty_arr = [];

        foreach ($user_list_by_stream  as $val) {
            if (!$this->check_subject_id($empty_arr, $val->af)) {
                continue;
            } else {
                array_push($empty_arr, $val->af);
            }
        }

        foreach ($empty_arr as $val) {
            $third_table[$i] = [];
            $str = "";
            $total_mark_per_subject = 0;
            $mean_mark_per_student = 0;
            $grade_name_per_subject = '';
            $overal_grading_sys = [];
            $grade_names = [];
            $overgradingsys = $exam_records[0]->overal_grading_sys;
            $grades = $this->exam->get_grades($overgradingsys);
            $total_remark = 0;
            $mean_remark = 0;
            $remark = 0;
            $user_list = $this->exam->get_users($val, $stream_id, $exam_id);
            $class_type_id = 0;
            $mark = 0;
            $subject_name = $this->exam->subject_name($val)->title;
            foreach ($user_list as $user_per) {
                $grade_name_perstudent_subejct = '';
                $mark = $user_per->pos;
                $class_type_id = $user_per->class_types_id;
                $grades = $this->exam->get_grades($class_type_id);
                foreach ($grades as $grade) {
                    if ($mark >= $grade->mark_from && $mark <= $grade->mark_to) {
                        $grade_name_perstudent_subejct = $grade->name;
                        $remark =  $grade->remark;
                    }
                }
                array_push($grade_names, $grade_name_perstudent_subejct);
            }
            foreach ($user_list_by_stream as $value) {
                if ($val == $value->af) {
                    $str = $str . $value->pos . ",";
                    $overal_grading_sys = $value->class_type->grades;
                }
            }
            $str = substr($str, 0, (strlen($str) - 1));
            $mark_arr = explode(",", $str);
            foreach ($mark_arr as $mark_val) {
                $total_mark_per_subject += (int)$mark_val;
            }
            $mean_mark_per_subject = round($total_mark_per_subject / count($mark_arr), 2);
            foreach ($overal_grading_sys as  $grade_val) {
                if ($mean_mark_per_subject >= $grade_val->mark_from && $mean_mark_per_subject <= $grade_val->mark_to) {
                    $grade_name_per_subject = $grade_val->name;
                }
            }
            $total_remark +=  $remark;
            $mean_remark = round($total_remark / count($mark_arr), 2);
            $entry = count($mark_arr);
            array_push($grade_names, $grade_name_per_subject);
            $grade_name = '';
            foreach ($overal_grading_sys as  $grade_val) {
                if ($mean_mark_per_subject >= $grade_val->mark_from && $mean_mark_per_subject <= $grade_val->mark_to) {
                    $grade_name = $grade_val->name;
                }
            }
            array_push($third_table[$i], $subject_name, $entry, $mean_mark_per_subject, $grade_name, $grade_names, $mean_remark);
            $i++;
        }
        //third_talbe end


        return json_encode([
            "data" => $data, 'student_list' => $student_arr, "previous_student_list" => $previous_arr, "exam_name" => $exam_name,
            "form_name" => $form_name, "stream_name" => $stream_name_by_id, 'second_table' => $second_table, "third_table" => $third_table,
        ]);
    }

    public function get_stream_stu_marks(Request $req)
    {
        $form_id = $req->form;
        $stream_id = $req->stream;
        $subject_id = $req->subject_id;
        if ($stream_id === "Select Stream" && $subject_id === "Select subject") {
            $streamarr = [];
            $getstream = $this->my_class->getClass($form_id);
            foreach ($getstream as $val) {
                array_push($streamarr, $val->id);
            }
            $streamdataarr = [];
            foreach ($streamarr as $eachid) {
                $student_arr = $this->my_class->get_stu_list($eachid)->toArray();;
                $streamdataarr = array_merge($streamdataarr, $student_arr);
            }
            if (count($streamdataarr) === 0) {
                return json_encode([
                    "data" => "Sorry.There is no such a data ",
                    "code" => 0
                ]);
            } else {
                return json_encode([
                    "data" => $streamdataarr,
                    "code" => 1
                ]);
            }
        } else if ($subject_id === "Select subject") {
            $student_arr = $this->my_class->get_stu_list($stream_id);
            if (count($student_arr) === 0) {
                return json_encode([
                    "data" => "Sorry.There is no such a data ",
                    "code" => 0
                ]);
            } else {
                return json_encode([
                    "data" => $student_arr,
                    "code" => 1
                ]);
            }
        } else {
            $student_arr = $this->my_class->get_stu_list($stream_id);
            if (count($student_arr) === 0) {
                return json_encode([
                    "data" => "Sorry.There is no such a data ",
                    "code" => 0
                ]);
            } else {
                return json_encode([
                    "data" => $student_arr,
                    "code" => 1
                ]);
            }
        }
    }

    public function custom_excel_download(Request $req)
    {
        dd($req['values']);
    }

    public function getsubjectlists(Request $req)
    {
        $form_id = $req['form'];
        $stream_id = $req['stream'];
        $subjectlist = $this->my_class->get_subjectlists($stream_id);
        $array_sub = [];
        foreach ($subjectlist->class_subject as $sub) {
            $data = [$sub->subject->title, $sub->subject->id];
            array_push($array_sub, $data);
        }
        return json_encode(["subjects" => $array_sub]);
    }

    public function get_analysis_data(Request $req)
    {
        $stream_id = $req['stream_id'];
        $form_id = $req['form_id'];
        $exam_id = $req['exam_id'];
        $exam_name = $this->exam->get_exam_by_id($exam_id);
        $form_name = $this->exam->get_form_by_id($form_id);
        $stream_name_by_id = $this->exam->get_stream_by_id($stream_id);
        $exam_records = $this->exam->exam_records($exam_id, $stream_id);
        $overgrade_arr = [];
        $meatlisttalbe = $this->exam->metalisttable($stream_id);
        foreach ($meatlisttalbe as $each_val) {
            array_push($overgrade_arr, $each_val->over_grad);
        }

        //firth_table start
        $firth_table = [];
        $previous_id = $exam_id - 1;
        $user_list_by_stream = $this->my_class->get_userlist_from_exam_record($stream_id, $exam_id);
        $empty_arr = [];
        foreach ($user_list_by_stream  as $val) {
            if (!$this->check_subject_id($empty_arr, $val->af)) {
                continue;
            } else {
                array_push($empty_arr, $val->af);
            }
        }
        $i = 0;
        foreach ($empty_arr as $val) {
            $firth_table[$i] = [];
            $total_mark_per_subject = 0;
            $total_mark_per_subject_pre = 0;
            $overgradingsys = $exam_records[0]->overal_grading_sys;
            $grades = $this->exam->get_grades($overgradingsys);
            $total_remark = 0;
            $mean_remark = 0;
            $total_remark_pre = 0;
            $mean_remark_pre = 0;
            $remark = 0;
            $grade_names = [];
            $remark_pre = 0;
            $user_list = $this->exam->get_users($val, $stream_id, $exam_id);
            $user_list_pre = $this->exam->get_users($val, $stream_id, $previous_id);
            $class_type_id = 0;
            $mark = 0;
            $subject_name = $this->exam->subject_name($val)->title;
            foreach ($user_list as $user_per) {
                $mark = $user_per->pos;
                $class_type_id = $user_per->class_type_id;
                $grades = $this->exam->get_grades($class_type_id);
                foreach ($grades as $grade) {
                    if ($mark >= $grade->mark_from && $mark <= $grade->mark_to) {
                        $remark =  $grade->remark;
                        array_push($grade_names, $grade->name);
                    }
                }
                $total_mark_per_subject += $mark;
                $total_remark +=  $remark;
            }
            $mean_remark = round($total_remark / count($user_list), 2);
            $mean_mark_per_subject = round($total_mark_per_subject / count($user_list), 2);
            $entry = count($user_list);
            if (count($user_list_pre) > 0) {
                foreach ($user_list_pre as $user_per_pre) {
                    $mark_pre = $user_per_pre->pos;
                    $class_type_id = $user_per_pre->class_type_id;
                    $grades_pre = $this->exam->get_grades($class_type_id);
                    foreach ($grades_pre as $grade) {
                        if ($mark_pre >= $grade->mark_from && $mark_pre <= $grade->mark_to) {
                            $remark_pre =  $grade->remark;
                        }
                    }
                    $total_remark_pre +=  $remark_pre;
                    $total_mark_per_subject_pre += $mark_pre;
                }

                $mean_remark_pre = round($total_remark_pre / count($user_list_pre), 2);
                $mean_mark_per_subject_pre = round($total_mark_per_subject_pre / count($user_list_pre), 2);
            } else {
                $mean_remark_pre = 0;
                $mean_mark_per_subject_pre = 0;
            }
            $grade_name = '';
            $grades = $this->exam->get_grades($overgradingsys);
            foreach ($grades as  $grade_val) {
                if ($mean_mark_per_subject >= $grade_val->mark_from && $mean_mark_per_subject <= $grade_val->mark_to) {
                    $grade_name = $grade_val->name;
                }
            }
            $dev = $mean_remark -  $mean_remark_pre;
            $dev_mark = $mean_mark_per_subject -  $mean_mark_per_subject_pre;
            $subject_teacher_name = $this->exam->subject_teacher_name($val, $stream_id)[0]->teacher->user->name;
            array_push($firth_table[$i], $subject_name,     $grade_name, $grade_names,  $mean_remark, $mean_mark_per_subject,  round($dev, 2), round($dev_mark, 2), $entry, $subject_teacher_name);
            $i++;
        }

        //sixth_table start
        $sixth_table = [];
        $form_stream = $this->my_class->getformstream($form_id);
        $i = 0;
        foreach ($form_stream as $key => $val) {
            $sixth_table[$i] = [];
            $my_class_id = $val->id;
            $empty_arr = [];
            $exam_records = $this->exam->exam_records($exam_id, $my_class_id);
            $overgradingsys = $exam_records[0]->overal_grading_sys;
            $grades = $this->exam->get_grades($overgradingsys);
            $stream_name =  $val->stream;
            // empty array
            foreach ($exam_records  as $val) {
                if (!$this->check_student_id($empty_arr, $val->student_id)) {
                    continue;
                } else {
                    array_push($empty_arr, $val->student_id);
                }
            }
            $teacher_name = $this->my_class->get_stream_teacher_name($my_class_id)->teacher->user->name;
            // empty array
            $total_mark = 0;
            $total_mark_pre = 0;
            $overal_grading_sys = [];
            $grade_names = [];
            $total_remark = 0;
            $mean_remark = 0;
            foreach ($empty_arr as $key => $val) {
                $str = "";
                $str_pre = "";
                $total_mark_per_student = 0;
                $mean_mark_per_student = 0;
                $total_mark_per_student_pre = 0;
                $mean_mark_per_student_pre = 0;
                $grade_name_per_student = '';
                foreach ($exam_records as $value) {
                    if ($val == $value->student_id) {
                        $str = $str . $value->pos . ",";
                        $overal_grading_sys = $value->class_type->grades;
                    }
                }
                $str = substr($str, 0, (strlen($str) - 1));
                $mark_arr = explode(",", $str);
                foreach ($mark_arr as $mark_val) {
                    $total_mark_per_student += (int)$mark_val;
                }
                $mean_mark_per_student = round($total_mark_per_student / count($mark_arr), 2);
                $remark = 0;
                foreach ($overal_grading_sys as  $grade_val) {
                    if ($mean_mark_per_student >= $grade_val->mark_from && $mean_mark_per_student <= $grade_val->mark_to) {
                        $grade_name_per_student = $grade_val->name;
                        $remark = $grade_val->remark;
                    }
                }
                $total_remark += $remark;
                array_push($grade_names, $grade_name_per_student);
                if (count($this->exam->exam_records($exam_id - 1, $my_class_id)) > 0) {
                    $exam_records_pre = $this->exam->exam_records($exam_id - 1, $my_class_id);
                    foreach ($exam_records_pre as $value) {
                        if ($val == $value->student_id) {
                            $str_pre = $str_pre . $value->pos . ",";
                        }
                    }
                    $str_pre = substr($str_pre, 0, (strlen($str_pre) - 1));
                    $mark_arr_pre = explode(",", $str_pre);
                    foreach ($mark_arr_pre as $mark_val) {
                        $total_mark_per_student_pre += (int)$mark_val;
                    }
                    $mean_mark_per_student_pre = round($total_mark_per_student_pre / count($mark_arr_pre), 2);
                    $overal_grading_sys = $exam_records_pre[0]->overal_grading_sys;
                    $grades = $this->exam->get_grades($overgradingsys);
                    foreach ($grades as  $grade_val) {
                        if ($mean_mark_per_student_pre >= $grade_val->mark_from && $mean_mark_per_student_pre <= $grade_val->mark_to) {
                            $remark_pre = $grade_val->remark;
                        }
                    }
                } else {
                    $mean_mark_per_student_pre = 0;
                    $remark_pre = 0;
                }
                $total_mark +=  $mean_mark_per_student;
                $total_mark_pre +=  $mean_mark_per_student_pre;
                $total_remark_pre += $remark_pre;
            }


            $mean_mark = round($total_mark / count($empty_arr), 2);
            $mean_mark_pre = round($total_mark_pre / count($empty_arr), 2);
            $grade_name = '';
            $exam_records = $this->exam->exam_records($exam_id, $my_class_id);
            $overgradingsys = $exam_records[0]->overal_grading_sys;
            $grades = $this->exam->get_grades($overgradingsys);
            foreach ($grades as  $grade_val) {
                if ($mean_mark >= $grade_val->mark_from && $mean_mark <= $grade_val->mark_to) {
                    $grade_name = $grade_val->name;
                }
            }

            $mean_remark =  round($total_remark / count($empty_arr), 2);
            $mean_remark_pre =  round($total_remark_pre / count($empty_arr), 2);
            $entry = count($empty_arr);
            array_push($sixth_table[$i], $stream_name, $entry, $mean_mark, $grade_name, $grade_names, $mean_remark, round($mean_mark - $mean_mark_pre, 2), round($mean_remark - $mean_remark_pre, 2), $teacher_name, $my_class_id);
            $i++;
        }

        //sixth_table end
        //
        $empty_arr = [];
        $student_arr = [];
        $students_stream = $this->exam->students_stream($exam_id, $stream_id);
        foreach ($students_stream  as $val) {
            if (!$this->check_subject_id($empty_arr, $val->student_id)) {
                continue;
            } else {
                array_push($empty_arr, $val->student_id);
            }
        }
        foreach ($empty_arr as $key => $val) {
            $student_arr[$key] = [];
            $total_mark = 0;
            $total_mark_pre = 0;
            $mean_mark = 0;
            $total_points = 0;
            $student_subject_score = $this->exam->student_subject_score($exam_id, $val);
            $student_subject_score_pre = $this->exam->student_subject_score($exam_id - 1, $val);
            $overal_grading_sys =  $student_subject_score[0]->overal_grading_sys;
            $grades = $this->exam->get_grades($overgradingsys);
            foreach ($student_subject_score  as $subject_score) {
                $remark = 0;
                foreach ($grades  as  $grade) {
                    if ($subject_score->pos >= $grade->mark_from && $subject_score->pos <= $grade->mark_to) {
                        $remark = $grade->remark;
                    }
                }
                $total_points += $remark;
                $total_mark += $subject_score->pos;
            }
            $mean_mark = round($total_mark / count($student_subject_score), 2);
            $student_name = $this->my_class->get_student_name($val)->user->name;
            $adm_no = $this->my_class->get_student_name($val)->adm_no;
            $stream_name = $this->my_class->get_stream_name($stream_id)->stream;
            foreach ($grades  as  $grade) {
                if ($mean_mark >= $grade->mark_from && $mean_mark <= $grade->mark_to) {
                    $grade_name = $grade->name;
                }
            }
            if (count($student_subject_score_pre) > 0) {
                foreach ($student_subject_score_pre  as $subject_score_pre) {
                    $total_mark_pre += $subject_score_pre->pos;
                }
                $mean_mark_pre = round($total_mark_pre / count($student_subject_score_pre), 2);
            } else {
                $mean_mark_pre = 0;
            }
            $dev = $mean_mark -   $mean_mark_pre;
            array_push($student_arr[$key], $adm_no, $student_name, $stream_name, $mean_mark, round($dev, 2), $total_mark, $total_points, $grade_name, $val);
        }

        $form_stream = $this->my_class->getformstream($form_id);
        $student_arr_new = [];
        foreach ($form_stream as $key => $val) {
            $stream_stu = $this->exam->students_stream($exam_id, $val->id);
            $empty_arr = [];
            foreach ($stream_stu  as $val) {
                if (!$this->check_subject_id($empty_arr, $val->student_id)) {
                    continue;
                } else {
                    array_push($empty_arr, $val->student_id);
                }
            }
            $student_arr_new[$key] = [];
            $i = 0;
            foreach ($empty_arr as $val) {
                $student_arr_new[$key][$i] = [];
                $student_subject_score = $this->exam->student_subject_score($exam_id, $val);
                $total_mark = 0;
                foreach ($student_subject_score  as $subject_score) {
                    $total_mark += $subject_score->pos;
                }
                array_push($student_arr_new[$key][$i], $total_mark, $val);
                $i++;
            }
        }


        //
        //seventh_arr start
        $empty_arr = [];
        $result = $this->exam->exam_records($exam_id, $stream_id);
        foreach ($result  as $val) {
            if (!$this->check_student_id($empty_arr, $val->af)) {
                continue;
            } else {
                array_push($empty_arr, $val->af);
            }
        }
        $empty_child_arr = [];
        $form_stream = $this->my_class->getformstream($form_id);
        foreach ($form_stream  as $val) {
            if (!$this->check_student_id($empty_child_arr, $val->id)) {
                continue;
            } else {
                array_push($empty_child_arr, $val->id);
            }
        }
        $examrecords_by_subjects = [];
        foreach ($empty_arr as $key => $value) {
            $examrecords_by_subjects[$key] = [];
            $subject_name = $this->exam->subject_name($value)->title;
            $records_subject = $this->exam->records_subject($value, $exam_id);
            $empty_form_students = [];
            $empty_stream_students = [];
            $stream_id_arr = $this->exam->students_subject($exam_id, $value);
            foreach ($stream_id_arr  as $val) {
                if (!$this->check_student_id($empty_form_students, $val->student_id)) {
                    continue;
                } else {
                    array_push($empty_form_students, $val->student_id);
                }
            }

            $stream_id_arr_stream = $this->exam->get_users($value, $req["stream_id"], $exam_id);
            foreach ($stream_id_arr_stream  as $val) {
                if (!$this->check_student_id($empty_stream_students, $val->student_id)) {
                    continue;
                } else {
                    array_push($empty_stream_students, $val->student_id);
                }
            }
            $i = 0;
            $total_remark = 0;
            $mean_remark = 0;
            $total_mark = 0;
            $mean_mark = 0;
            $total_remark_pre = 0;
            $mean_remark_pre = 0;
            $total_mark_pre = 0;
            $mean_mark_pre = 0;
            foreach ($empty_child_arr as $stream_id) {
                $examrecords_by_subjects[$key][$i] = [];
                $grade_name = '';
                $grade_names = [];
                $j = 0;
                foreach ($records_subject as $val) {
                    if ($stream_id == $val->my_class_id) {
                        $overal_grading_sys = $val->overal_grading_sys;
                        $grades = $this->exam->get_grades($overal_grading_sys);
                        foreach ($grades  as  $grade) {
                            if ($val->pos >= $grade->mark_from && $val->pos <= $grade->mark_to) {
                                $total_remark += $grade->remark;
                                array_push($grade_names, $grade->name);
                            }
                        }
                        $total_mark += $val->pos;
                        $j++;
                    }
                }
                if ($j == 0) {
                    array_push($examrecords_by_subjects[$key][$i], [], 0, 0,  0, 0, 0, "", "");
                } else {
                    $mean_mark = round($total_mark / $j, 2);
                    $mean_remark = round($total_remark / $j, 2);
                    foreach ($grades  as  $grade) {
                        if ($mean_mark  >= $grade->mark_from &&  $mean_mark  <= $grade->mark_to) {
                            $grade_name =  $grade->name;
                        }
                    }
                    $students_score_pre = $this->exam->get_users($value, $stream_id, $exam_id - 1);
                    if (count($students_score_pre) > 0) {
                        foreach ($students_score_pre as $pre_val) {
                            $overal_grading_sys = $pre_val->overal_grading_sys;
                            $grades = $this->exam->get_grades($overal_grading_sys);
                            foreach ($grades  as  $grade) {
                                if ($pre_val->pos >= $grade->mark_from && $pre_val->pos <= $grade->mark_to) {
                                    $total_remark_pre += $grade->remark;
                                }
                            }
                            $total_mark_pre += $pre_val->pos;
                        }
                        $mean_mark_pre = round($total_mark_pre / count($students_score_pre), 2);
                        $mean_remark_pre = round($total_remark_pre / count($students_score_pre), 2);
                    } else {
                        $mean_mark_pre = 0;
                        $mean_remark_pre = 0;
                    }
                    $dev_meanmark =  $mean_mark - $mean_mark_pre;
                    $dev_mean_point =  $mean_remark - $mean_remark_pre;
                    $subject_teacher_name = $this->exam->subject_teacher_name($value, $stream_id)[0]->teacher->user->name;
                    $stream_name = $this->my_class->get_stream_name($stream_id)->stream;
                    array_push($examrecords_by_subjects[$key][$i], $subject_name, $stream_id, $stream_name, $grade_names, $j, $mean_mark,  $dev_meanmark, $mean_remark, $dev_mean_point, $grade_name, $subject_teacher_name);
                }
                $i++;
            }
            $form_mark_arr = [];
            $k = 0;
            foreach ($empty_form_students as $form_per_val) {
                $form_mark_arr[$k] = [];
                foreach ($records_subject as $pp) {
                    if ($form_per_val == $pp->student_id) {
                        array_push($form_mark_arr[$k], $pp->pos, $pp->student_id);
                    }
                }
                $k++;
            }
            $form_mark_arr_stream = [];
            $p = 0;
            foreach ($empty_stream_students as $form_per_val_stream) {
                $form_mark_arr_stream[$p] = [];
                foreach ($records_subject as $pp) {
                    if ($form_per_val_stream == $pp->student_id) {
                        $student_name = $this->my_class->get_student_name($form_per_val_stream)->user->name;
                        $adm_no = $this->my_class->get_student_name($form_per_val_stream)->adm_no;
                        $stream_name = $this->my_class->get_stream_name($req['stream_id'])->stream;
                        $overal_grading_sys = $pp->overal_grading_sys;
                        $grades = $this->exam->get_grades($overal_grading_sys);
                        foreach ($grades  as  $grade) {
                            if ($pp->pos >= $grade->mark_from && $pp->pos <= $grade->mark_to) {
                                $grade_name = $grade->name;
                            }
                        }
                        array_push($form_mark_arr_stream[$p],  $adm_no, $student_name,  $stream_name, $pp->pos, $grade_name, $pp->student_id);
                    }
                }
                $p++;
            }
            array_push($examrecords_by_subjects[$key], $form_mark_arr_stream, $form_mark_arr);
        }
        //seventh_arr end
        return json_encode([
            "exam_name" => $exam_name, "form_name" => $form_name, "stream_name" => $stream_name_by_id,
            "firth_table" => $firth_table,  'sixth_table' => $sixth_table, 'seventh_table' => $examrecords_by_subjects, "student_arr" => $student_arr, "student_arr_new" => $student_arr_new,
            "overgrade_arr" => $overgrade_arr
        ]);
    }

    public function getOrderStudentByMark($form_id,  $stream_id, $exam_id)
    {
        $streams = $this->exam->get_stream_id_by_formid($form_id);
        $marksArray = [];
        foreach ($streams as $key => $stream) {
            $marksArray[$key] = [];
            $students = $this->my_class->get_studenst($stream->id);
            foreach ($students as $each_stu) {
                $student_id = $each_stu->id;
                $student_exam_results = $this->exam->getExamrecordsPerStudent($student_id, $exam_id, $stream_id);
                $Total_got_marks = 0;
                foreach ($student_exam_results as $markpersub) {
                    $Total_got_marks += $markpersub->pos;
                }
                array_push($marksArray[$key], [$Total_got_marks, $student_id]);
            }
        }
        $oneDArray = array_reduce($marksArray, 'array_merge', array());
        return $oneDArray;
    }

    public function exposeOrderofArray_Overall($array, $studentId)
    {
        usort($array, function ($a, $b) {
            return $b[0] - $a[0];
        });
        foreach ($array as $key => $element) {
            if ($element[1] == $studentId) {
                return $key;
            }
        }
        // if the student ID is not found in the array
        return -1;
    }

    public function getStudentStream($stream_id, $exam_id)
    {
        $marksArray = [];
        $students = $this->my_class->get_studenst($stream_id);
        foreach ($students as $each_stu) {
            $student_id = $each_stu->id;
            $student_exam_results = $this->exam->getExamrecordsPerStudent($student_id, $exam_id, $stream_id);
            $Total_got_marks = 0;
            foreach ($student_exam_results as $markpersub) {
                $Total_got_marks += $markpersub->pos;
            }
            array_push($marksArray, [$Total_got_marks, $student_id]);
        }
        return $marksArray;
    }

    public function get_meta_data_for_report_form(Request $req)
    {
        $stream_id = $req['stream_id'];
        $exam_id = $req['exam_id'];
        $form_id = $req['form_id'];
        $oneDArray = $this->getOrderStudentByMark($form_id,  $stream_id, $exam_id);
        $streamArray = $this->getStudentStream($stream_id, $exam_id);
        $stream_name = $this->my_class->get_stream_name($stream_id)->stream;
        $students = $this->my_class->get_studenst($stream_id);
        $arranged_stu_arr = [];
        foreach ($students as $each_stu) {
            $student_id = $each_stu->id;
            $over_order = $this->exposeOrderofArray_Overall($oneDArray, $student_id);
            $stream_order = $this->exposeOrderofArray_Overall($streamArray, $student_id);
            $student_exam_results = $this->exam->getExamrecordsPerStudent($student_id, $exam_id, $stream_id);
            $pre_student_exam_results = $this->exam->getExamrecordsPerStudent($student_id, intval($exam_id) - 1, $stream_id);
            $TotalofMaxpoint_pre = 0;
            $Total_got_marks_pre = 0;
            $Total_point_pre = 0;
            if (count($pre_student_exam_results) === 0) {
                $TotalofMaxpoint_pre = 0;
                $Total_got_marks_pre = 0;
                $Total_point_pre = 0;
                $meanmark_pre = 0;
            } else {
                foreach ($pre_student_exam_results as $pre_stu) {
                    $TotalofMaxpoint_pre += $pre_stu->p_comment;
                    $Total_got_marks_pre += $pre_stu->pos;
                    $grades = $pre_stu->class_type->grades;
                    foreach ($grades as $grade) {
                        if ($grade->mark_from <= $pre_stu->pos && $grade->mark_to > $pre_stu->pos) {
                            $Total_point_pre += $grade->remark;
                        }
                    }
                }
                $meanmark_pre = number_format($Total_got_marks_pre / count($pre_student_exam_results), 2);
            }

            $TotalofMaxpoint = 0;
            $Total_got_marks = 0;
            $Total_point = 0;
            foreach ($pre_student_exam_results as $markpersub) {
                $TotalofMaxpoint += $markpersub->p_comment;
                $Total_got_marks += $markpersub->pos;
                $grades = $markpersub->class_type->grades;
                foreach ($grades as $grade) {
                    if ($grade->mark_from <= $markpersub->pos && $grade->mark_to > $markpersub->pos) {
                        $Total_point += $grade->remark;
                    }
                }
            }
            $meanmark = number_format($Total_got_marks / count($student_exam_results), 2);
            $grades = $student_exam_results[0]->class_type->grades;
            $meangrade = "";

            foreach ($grades as $grade) {
                if ($grade->mark_from <= $meanmark && $grade->mark_to > $meanmark) {
                    $meangrade = $grade->name;
                }
            }

            $subjects_student = $this->exam->getSubject_Student($student_id, $exam_id);
            $empty_arr = [];
            foreach ($subjects_student  as $val) {
                if (!$this->check_subject_id($empty_arr, $val->af)) {
                    continue;
                } else {
                    array_push($empty_arr, $val->af);
                }
            }
            $tabledata = [];
            foreach ($empty_arr as $subject) {
                foreach ($subjects_student as $entity) {
                    if ($subject == $entity->af) {
                        $subjectName = $this->exam->subject_name($subject)->title;
                        $preexamarrr = $this->exam->getArray($subject, $student_id, intval($exam_id) - 1);
                        $mark_pre =  intval($preexamarrr->pos) / intval($preexamarrr->p_comment);
                        $mark =  intval($entity->pos) / intval($entity->p_comment);
                        $grades = $entity->class_type->grades;
                        $grade_name = "";
                        foreach ($grades as $key => $grade) {
                            if ($grade->mark_from <= $entity->pos && $grade->mark_to > $entity->pos) {
                                $grade_name = $grade->name;
                            }
                        }
                        $subject_marks_arr = $this->exam->getSubject_marks_arr($exam_id, $subject, $stream_id);
                        $subject_arr = [];
                        foreach ($subject_marks_arr as $entity_per) {
                            array_push($subject_arr, [$entity_per->pos, $entity_per->student_id]);
                        }
                        $order_in_subject_marks = $this->exposeOrderofArray_Overall($subject_arr, $student_id);
                        $rank = $order_in_subject_marks . '/' . count($subject_arr);
                        $comment = "Below average, can do better";
                        $teacher_name = $this->exam->getSubjectTeacherName($subject, $stream_id)->teacher->user->name;
                        $tabledata = [
                            "subjectName" => $subjectName,
                            "mark" => ($mark*100)."%",
                            "dev" => ($mark - $mark_pre)*100,
                            "grade" => $grade_name,
                            "rank" => $rank,
                            "comment" => $comment,
                            "teachername" => $teacher_name
                        ];
                    }
                }
            }
            $data = [
                "admno" => $each_stu->adm_no,
                "name" => $each_stu->user->name,
                "stream_name" => "Form:" . " " . $form_id . " " . $stream_name,
                "current_total_maxmarks" => $TotalofMaxpoint,
                "deviation_marks>" => $TotalofMaxpoint - $TotalofMaxpoint_pre,
                "totalpoint" => $Total_point,
                "dev_point" => $Total_point - $Total_point_pre,
                "over_order" => $over_order,
                "mean_marks" => $meanmark,
                "dev_mean_mark" => $meanmark - $meanmark_pre,
                "meangrade" => $meangrade,
                "streamorder" => $stream_order,
                "total_memeber_form" => count($oneDArray),
                "total_member_stream" => count($streamArray),
                "tabledata"=>$tabledata
            ];

            array_push($arranged_stu_arr,  $data );
        }
        return json_encode(["data"=>$arranged_stu_arr]);
    }

    public function get_each_student_marks($data, $form_id, $exam_id)
    {
        $str = '';
        $empty_arr = [];
        $student_arr = [];
        $res = $this->exam->get_stream_id_by_formid($form_id);
        $student_marks_arr_form = $this->get_student_marks_form($res, $exam_id);
        $ordered_arr = $student_marks_arr_form;
        foreach ($data  as $val) {
            if (!$this->check_student_id($empty_arr, $val->student_id)) {
                continue;
            } else {
                array_push($empty_arr, $val->student_id);
            }
        }
        foreach ($empty_arr as $key => $val) {
            $student_adm_no = "";
            $student_name = "";
            $stream_name = "";
            $overal_grading_sys = '';
            $str = "";
            $student_id = $val;
            $pre_total_mark = 0;
            $pre_mean_mark = 0;
            foreach ($data as $value) {
                if ($val == $value->student_id) {
                    $str = $str . $value->pos . ",";
                    $student_adm_no = $value->student->adm_no;
                    $student_name = $value->student->user->name;
                    $stream_name = $value->student->my_class->stream;
                    $overal_grading_sys = $value->class_type->grades;
                    $pre_exam_id = $exam_id - 1;
                    $prev_marks_data = $this->exam->get_marks_pre_exam($val, $pre_exam_id);
                    // dd(count($prev_marks_data));
                    foreach ($prev_marks_data as $prev_mark) {
                        $pre_total_mark += $prev_mark['pos'];
                    }
                    if (count($prev_marks_data) == 0) {
                        $pre_mean_mark = 0;
                    } else {
                        $pre_mean_mark = $pre_total_mark / count($prev_marks_data);
                    }
                }
            }
            $str = substr($str, 0, (strlen($str) - 1));
            $mark_arr = explode(",", $str);
            $mark_arr_new = [];
            foreach ($mark_arr as $mark) {
                if ($mark) {
                    foreach ($value->class_type->grades as $grade) {
                        if ($mark > $grade->mark_from && $mark <= $grade->mark_to) {
                            array_push($mark_arr_new, $mark . $grade->name);
                        }
                    }
                } else if ($mark == null) {
                    array_push($mark_arr_new, '');
                }
            }

            $student_arr[$key] = array([
                "student_id" => $student_id, "adm_no" => $student_adm_no, "Name" => $student_name, "stream_name" => $stream_name, "marks" => $mark_arr, "marks_new" => $mark_arr_new, "overal_grading_sys" => $overal_grading_sys,
                "student_marks_form" => $ordered_arr, "pre_mean_mark" => $pre_mean_mark
            ]);
        }
        return   $student_arr;
    }

    // public function odering_method($arr)
    // {
    //     $temp = [];
    //     $data_arr = $arr;
    //     // dd($data_arr);
    //     foreach ($data_arr as $key => $val) {
    //         $total_mark = 0;
    //         foreach ($val[0]['marks'] as $value) {
    //             $total_mark += intval($value);
    //         }
    //         array_push($data_arr[$key][0]['marks'], $total_mark);
    //     }
    //     for ($i = 0; $i < count($data_arr); $i++) {
    //         for ($j = 0; $j < count($data_arr); $j++) {
    //             if ($i == $j) {
    //                 continue;
    //             } else {
    //                 if ($data_arr[$i][0]['marks'] > $data_arr[$j][0]['marks']) {
    //                     $temp = $data_arr[$j];
    //                     $data_arr[$j] = $data_arr[$i];
    //                     $data_arr[$i] = $temp;
    //                 } else {
    //                     continue;
    //                 }
    //             }
    //         }
    //     }
    //     return  $data_arr;
    // }

    public function get_student_marks_form($res, $exam_id)
    {
        $student_marks_arr = [];
        $empty_arr = [];
        $student_arr = [];
        foreach ($res as $res_val) {
            $resdata = $this->exam->get_students_marks_by_form_id_exam_id($res_val->id, $exam_id);
            array_push($student_marks_arr, $resdata);
        }
        foreach ($student_marks_arr  as $val) {
            foreach ($val as $each_val) {
                if (!$this->check_student_id($empty_arr, $each_val->student_id)) {
                    continue;
                } else {
                    array_push($empty_arr, $each_val->student_id);
                }
            }
        }
        foreach ($empty_arr as $key => $val) {
            $student_id = "";
            $str = "";
            foreach ($student_marks_arr as $value) {
                foreach ($value as $each_val) {
                    if ($val == $each_val->student_id) {
                        $str = $str . $each_val->pos . ",";
                        $student_id = $each_val->student_id;
                    }
                }
            }
            $str = substr($str, 0, (strlen($str) - 1));
            $mark_arr = explode(",", $str);
            $student_arr[$key] = array(["student_id" => $student_id, "marks" => $mark_arr]);
        }
        return $student_arr;
    }

    public function adding_metalist_table(Request $req)
    {
        $new_arr = [];
        foreach ($req['data'] as $key => $val) {
            if ($key == "marks_new") {
                $mark_arr = "";
                $mark_arr = implode(",", $val);
                array_push($new_arr, $mark_arr);
            } else {
                array_push($new_arr, $val);
            }
        }

        $this->exam->create_metalist($new_arr);
    }

    // public function download_metalist_excel(Request $req)
    // {
    //     return Excel::download(new ExportMetalist($req["exam_id"], $req["stream_id"]), 'users.xlsx');
    // }


    public function download_classlist_excel(Request $req)
    {
        if (count($req['values']) > 0) {
            return Excel::download(new ExportCustomExcel($req["form_id"], $req["stream_id"], $req["values"]), 'users.xlsx');
        } else {
            return Excel::download(new Exportclasslist($req["form_id"], $req["stream_id"]), 'users.xlsx');
        }
    }
    public function download_metalist_pdf(Request $req)
    {
        $stream_id = $req['stream_id'];
        $exam_id = $req['exam_id'];
        $form_id = $req['form_id'];
        $exam_name = Exam::where("id", $exam_id)->first();
        $form_name = Form::where("id", $form_id)->first()->name;
        $stream_name = MyClass::where("id", $stream_id)->first()->stream;
        $data = $this->exam->get_metalist_from_db($stream_id, $exam_id);
        $subject_name = $data[0]->subject_name;
        $subject_name_new = substr($subject_name, 0, strlen($subject_name) - 1);
        $subject_arr = explode(",", $subject_name_new);
        $marks = $data[0]->subject_name;
        $pdf_data = ["subject_arr" => $subject_arr, 'data' => $data, 'exam_name' => $exam_name, 'form_name' => $form_name, 'stream_name' => $stream_name];
        $customPaper = array(0, 0, 900, 900);
        $pdf = PDF::loadView('pdf_view', $pdf_data)->setPaper($customPaper, 'landscape');
        return $pdf->download('itsolutionstuff.pdf');
        // return view('pdf_view',$pdf_data);

    }

    public function download_class_list_pdf(Request $req)
    {

        $stream_id = $req['stream_id'];
        $form_id = $req['form_id'];
        $student_arr = $this->my_class->get_stu_list($stream_id);
        $data_arr = ["data" => $student_arr];
        $customPaper = array(0, 0, 900, 900);
        $pdf = PDF::loadView('pdf_viewnew', $data_arr)->setPaper($customPaper, 'landscape');
        return $pdf->download('itsolutionstuff.pdf');
    }
}