<?php

namespace App\Http\Controllers\SupportTeam;

use Illuminate\Http\Request;
use App\Helpers\Qs;
use App\Http\Requests\Exam\ExamCreate;
use App\Http\Requests\Exam\ExamUpdate;
use App\Repositories\ExamRepo;
use App\Repositories\MarkRepo;
use App\Repositories\MyClassRepo;
use App\Repositories\TeacherRepo;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepo;
use Illuminate\Support\Facades\Validator;

use App\Models\Exam;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Repositories\MessageRepo;

class ExamController extends Controller
{
    protected $exam;
    protected $my_class;
    protected $teachers;
    protected $mark;
    protected $user;
    protected $message_repo;
    public function __construct(ExamRepo $exam, MyClassRepo $my_class, MarkRepo $mark, TeacherRepo $teachers, UserRepo $user, MessageRepo $message_repo)
    {
        // $this->middleware('teamSA', ['except' => ['destroy',] ]);
        // $this->middleware('super_admin', ['only' => ['destroy',] ]);

        $this->exam = $exam;
        $this->my_class = $my_class;
        $this->mark = $mark;
        $this->teachers = $teachers;
        $this->user = $user;
        $this->message_repo = $message_repo;
    }

    public function index()
    {
        $d['exams'] = $this->exam->all();
        $d['forms'] = $this->my_class->getAllForms();
        $d['myclasses'] = $this->my_class->getAllMyClasses();
        $d['types'] = Qs::getUserType();
        $d['teachers'] = $this->teachers->getAllTeachers();
        $d['grades'] = $this->my_class->allClassTypeWithNotNull();
        $d['subjects'] = $this->my_class->allSubjects();
        $d['subjects'] = $this->my_class->fifteenSubject();
        $d['deleteds'] = $this->exam->getAllExamFormsByDeleted();
        $user_id = Qs::getUserID();
        if ($this->teachers->findTeacherbyUserID($user_id) !== null) {
            $teacher_id = $this->teachers->findTeacherbyUserID($user_id)->id;
            $d['hasmyownclass'] = (count($this->my_class->getClassByTeacher($teacher_id)) > 0) ? 1 : 0;
            $d['hasmyownsubjectclass'] = (count($this->my_class->getClassSubjects($teacher_id)) > 0) ? 1 : 0;
            $d['hasmyownform'] = (count($this->my_class->findFormbyteahcer_id($teacher_id)) > 0) ? 1 : 0;
        } else {
            $d['hasmyownclass'] = 0;
            $d['hasmyownsubjectclass'] = 0;
            $d['hasmyownform'] =  0;
        }


        if ($this->exam->last() == Null) {
            $d['last'] = null;
        } else {
            $d['last'] = $this->exam->last();
        }
        $d['last'] = $this->exam->last();
        $d['user'] = Qs::getUserName();
        $this->user->updateZero();
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        return view('pages.support_team.exams.index', $d);
    }


    public function exams2()
    {
        $d['exams'] = $this->exam->all();
        $d['forms'] = $this->my_class->getAllForms();
        $d['myclasses'] = $this->my_class->getAllMyClasses();
        $d['types'] = Qs::getUserType();
        $d['teachers'] = $this->teachers->getAllTeachers();
        $d['grades'] = $this->my_class->allClassTypeWithNotNull();
        $d['subjects'] = $this->my_class->allSubjects();
        $d['subjects'] = $this->my_class->fifteenSubject();
        $d['deleteds'] = $this->exam->getAllExamFormsByDeleted();
        $user_id = Qs::getUserID();
        if ($this->teachers->findTeacherbyUserID($user_id) !== null) {
            $teacher_id = $this->teachers->findTeacherbyUserID($user_id)->id;
            $d['hasmyownclass'] = (count($this->my_class->getClassByTeacher($teacher_id)) > 0) ? 1 : 0;
            $d['hasmyownsubjectclass'] = (count($this->my_class->getClassSubjects($teacher_id)) > 0) ? 1 : 0;
            $d['hasmyownform'] = (count($this->my_class->findFormbyteahcer_id($teacher_id)) > 0) ? 1 : 0;
        } else {
            $d['hasmyownclass'] = 0;
            $d['hasmyownsubjectclass'] = 0;
            $d['hasmyownform'] =  0;
        }


        if ($this->exam->last() == Null) {
            $d['last'] = null;
        } else {
            $d['last'] = $this->exam->last();
        }
        $d['last'] = $this->exam->last();
        $d['user'] = Qs::getUserName();
        $this->user->updateZero();
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        return view('pages.support_team.exams.index2', $d);
    }

    public function show($id)
    {
        //
        $d['exam'] = $this->exam->find($id);
        $d['forms'] = $this->my_class->getAllForms();
        $d['types'] = Qs::getUserType();
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        return view('pages.support_team.exams.show', $d);
    }
    public function update(Request $req, $id)
    {
        $data['name'] = $req->exam_name;
        $res = $this->exam->update($id, $data);
        $data['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        // if($res) return json_encode(['ok' => true, 'msg' => "Updated Successfully"]);
        return redirect()->route('exams.show', $id);
    }

    public function publish_result(Request $req)
    {
        echo $req->f;
        if ($req->f == "true") {
            echo "publish";
            $data['flag'] = true;
        } else {
            echo "unpublish";
            $data['flag'] = false;
        }
        $res = $this->my_class->examform_table_update($req->id, $data);
    }

    public function exam_manage_config($exam_id, $form_id)
    {
        $d['exam'] = $this->exam->find($exam_id);
        $d['form'] = $this->exam->getForm($form_id);
        $d['types'] = Qs::getUserType();
        $d['subjects'] = $this->my_class->allSubjects();
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        return view('pages.support_team.exams.exam_manage_config', $d);
    }
    public function exam_manage_upload($exam_id, $form_id)
    {
        $d['exam'] = $this->exam->find($exam_id);
        $d['form'] = $this->exam->getForm($form_id);
        $d['types'] = Qs::getUserType();
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        return view('pages.support_team.exams.exam_manage_upload', $d);
    }
    public function exam_manage_add($exam_id)
    {
        $d['exam_forms'] = $this->exam->getExamFormsByExamId($exam_id);
        $d['types'] = Qs::getUserType();
        $d['exam_id'] = $exam_id;
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        // print_r($d['exam_forms']);
        return view('pages.support_team.exams.exam_manage_add', $d);
    }
    public function exam_grading_add()
    {
        $d['exams'] = $this->exam->all();
        $d['forms'] = $this->my_class->getAllForms();
        $d['types'] = Qs::getUserType();
        $d['grades'] = $this->mark->allGrades();
        $d['grades_max'] = $this->mark->maxGrades();
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        return view('pages.support_team.exams.exam_grading_add', $d);
    }
    public function exam_grading_view($grade_id)
    {
        $d['exams'] = $this->exam->all();
        $d['forms'] = $this->my_class->getAllForms();
        $d['types'] = Qs::getUserType();
        $d['grade'] = $this->exam->allGradesWithNoNull($grade_id);
        $d['class_type_name'] = $this->my_class->findType($grade_id);
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        return view('pages.support_team.exams.exam_grading_view', $d);
    }
    public function exam_class_upload($class_subject_id, $exam_id, $teacher_id, $subject_id)
    {
        $d['exam'] = $this->exam->find($exam_id);
        $d['exams'] = $this->exam->all();
        $d['forms'] = $this->my_class->getAllForms();
        $d['class_subject'] = $this->my_class->getClassSubject($class_subject_id);
        $d['types'] = Qs::getUserType();
        $d['class_subject_id'] = $class_subject_id;
        $d['exam_id'] = $exam_id;
        $d['teacher_id'] = $teacher_id;
        $d['subject_id'] = $subject_id;
        $d['subject'] = $this->my_class->findSubject($subject_id);
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        return view('pages.support_team.exams.exam_class_upload', $d);
        // return json_encode(['subject'=>$d['subject']]);
    }
    public function exam_class_upload_view($class_subject_id, $exam_id, $teacher_id, $subject_id)
    {
        // $d['exam'] = $this->exam->find($exam_id);
        // $d['forms'] = $this->my_class->getAllForms();
        // $d['class_subject'] = $this->my_class->getClassSubject($class_subject_id);
        // $data['exam_id'] = $exam_id;
        // $data['af'] = $subject_id;
        // $d['marks'] = $this->exam->getRecord($data);
        // $d['types'] = Qs::getUserType();
        // $d['class_subject_id'] = $class_subject_id;
        // $d['exam_id'] = $exam_id;
        // $d['teacher_id'] = $teacher_id;
        // $d['subject_id'] = $subject_id;
        // $d['papers'] = $this->my_class->findSection($d['marks'][0]['section_id']);
        // $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        $d['exam'] = $this->exam->find($exam_id);
        $d['forms'] = $this->my_class->getAllForms();
        $d['class_subject'] = $this->my_class->getClassSubject($class_subject_id);
        $data['exam_id'] = $exam_id;
        $data['af'] = $subject_id;
        $d['marks'] = $this->exam->getRecord($data);
        $d['max_mark'] = $d['marks'][0]->p_comment;
        $d['types'] = Qs::getUserType();
        $d['class_subject_id'] = $class_subject_id;
        $d['exam_id'] = $exam_id;
        $d['class_id'] = $d['marks'][0]['my_class_id'];
        $d['teacher_id'] = $teacher_id;
        $d['subject_id'] = $subject_id;
        $d['is_upload'] = $this->exam->is_check_published($exam_id, $d['class_id'], $subject_id)->is_upload;
        $d['papers'] = $this->my_class->findSection($d['marks'][0]['section_id']);
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        $d['user'] = Auth::user();
        return view('pages.support_team.exams.exam_class_upload_view', $d);
        // return json_encode(['data'=>$d['papers']]);
    }
    public function exam_class_upload_publish($class_subject_id, $exam_id, $teacher_id, $subject_id)
    {
        $d['exam'] = $this->exam->find($exam_id);
        $d['forms'] = $this->my_class->getAllForms();
        $d['class_subject'] = $this->my_class->getClassSubject($class_subject_id);
        $data['exam_id'] = $exam_id;
        $data['af'] = $subject_id;
        $d['marks'] = $this->exam->getRecord($data);
        $d['max_mark'] = $d['marks'][0]->p_comment;
        $d['types'] = Qs::getUserType();
        $d['class_subject_id'] = $class_subject_id;
        $d['exam_id'] = $exam_id;
        $d['class_id'] = $d['marks'][0]['my_class_id'];
        $d['teacher_id'] = $teacher_id;
        $d['subject_id'] = $subject_id;
        $d['papers'] = $this->my_class->findSection($d['marks'][0]['section_id']);
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        $d['user'] = Auth::user();
        return view('pages.support_team.exams.exam_class_upload_publish', $d);
        // return json_encode(['data'=>$d['papers']]);
    }
    public function exam_class_download_publish($class_subject_id, $exam_id, $teacher_id, $subject_id)
    {
        $d['exam'] = $this->exam->find($exam_id);
        $d['forms'] = $this->my_class->getAllForms();
        $d['class_subject'] = $this->my_class->getClassSubject($class_subject_id);
        $data['exam_id'] = $exam_id;
        $data['af'] = $subject_id;
        $d['marks'] = $this->exam->getRecord($data);
        $d['max_mark'] = $d['marks'][0]->p_comment;
        $d['types'] = Qs::getUserType();
        $d['class_subject_id'] = $class_subject_id;
        $d['exam_id'] = $exam_id;
        $d['class_id'] = $d['marks'][0]['my_class_id'];
        $d['teacher_id'] = $teacher_id;
        $d['subject_id'] = $subject_id;
        $d['papers'] = $this->my_class->findSection($d['marks'][0]['section_id']);
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        $d['user'] = Auth::user();
        return view('pages.support_team.exams.exam_class_upload_publish', $d);
        // return json_encode(['data'=>$d['papers']]);
    }
    public function exam_class_view($forms_id, $exams_id)
    {
        $d['exams'] = $this->exam->find($exams_id);
        $d['forms'] = $this->my_class->findForm($forms_id);
        $d['types'] = Qs::getUserType();
        $d['class_subject'] = $this->my_class->getClassSubjectByTeacher($d['forms']->teacher_id);
        // $data['exam_id'] = $exam_id;
        // $d['marks'] = $this->exam->getRecord($data);
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        return view('pages.support_team.exams.exam_class_view', $d);
    }
    public function exam_class_publish_mark(Request $req)
    {
        if (isset($req->sort)) {
            switch ($req->sort) {
                case 1:
                    $existData = $this->exam->getExamMark1($req->exam_id, $req->student_id, $req->my_class_id);
                    if ($existData != null) {
                        if (isset($req->student_id)) {
                            $data['pos'] = isset($req->pos) ? $req->pos : null;
                            $this->exam->updateExamMark1($req->exam_id, $req->student_id, $req->my_class_id, $data);
                            return json_encode(['ok' => true, 'msg' => "Marks updated successfully"]);
                        } else {
                            if (isset($req->ps)) {
                                $data['ps'] = isset($req->ps) ? $req->ps : null;
                                for ($i = 0; $i < $req->class_exam_count; $i++) {
                                    $temp = '';
                                    $temp = "student" . $i;
                                    $student_id = $req->$temp;
                                    $this->exam->publishExam($req->examID, $student_id, $req->subjectID, $data);
                                }
                                return json_encode(['ok' => true, 'msg' => "Marks published successfully"]);
                            } else {
                                $data['p_comment'] = isset($req->p_comment) ? $req->p_comment : null;
                                $this->exam->updateExamMax($req->exam_id, $data);
                                return json_encode(['ok' => true, 'msg' => "Max Mark updated successfully"]);
                            }
                        }
                    } else {
                        $this->exam->insertExamMark1($req->exam_id, $req->student_id, $req->my_class_id, $req->section_id, $req->pos, $req->af, $req->p_comment);
                        return json_encode(['ok' => true, 'msg' => "New Mark inserted successfully"]);
                    }
                    break;
                case 2:
                    $data['pos'] = isset($req->pos) ? $req->pos : null;
                    $this->exam->updateExamMark1($req->exam_id, $req->student_id, $req->my_class_id, $req->subject_id, $data);
                    return json_encode(['ok' => true, 'msg' => "Marks updated successfully"]);
                case 3:
                    break;
                case 0:
                    $data['p_comment'] = isset($req->p_comment) ? $req->p_comment : null;
                    $this->exam->updateExamMax($req->exam_id, $data);
                    return json_encode(['ok' => true, 'msg' => "Max Mark updated successfully"]);
                default:
                    break;
            }
        } else {
            // $user_type = Qs::getUserType();
            // $user_id = Qs::getUserID();
            // $this_teacher_id  = $this->teachers->findTeacherbyUserID($user_id)->id;
            // $this_exam_subject_teacher_id =  $this->my_class->getsubjectteacherID($req->classID, $req->subjectID)->teacher_id;
            // $stream_teacher_id = $this->my_class->getClassAll($req->classID)->teacher_id;
            // $super_teacher_id = $req->formteacherID;
            // if ($this_teacher_id == $super_teacher_id) {
            //     $data['flag'] = 1;
            // } elseif ($this_teacher_id == $stream_teacher_id) {
            //     $data['flag'] = 2;
            // } elseif ($this_teacher_id == $this_exam_subject_teacher_id) {
            //     $data['flag'] = 3;
            // } elseif ($user_type == "super admin" || $user_type == "admin") {
            //     $data['flag'] = 4;
            // }
            $data['flag'] = 1;
            $data['ps'] = 1;
            $data['is_upload'] = 1;
            for ($i = 0; $i < $req->class_exam_count; $i++) {
                $temp = '';
                $temp = "student" . $i;
                $student_id = $req->$temp;
                $temp = '';
                $temp = "mark" . $i;
                if ($req->$temp == "X") {
                    $data['xy'] = 1;
                    $data['pos'] = 0;
                } elseif ($req->$temp == "Y") {
                    $data['pos'] = 0;
                    $data['xy'] = 2;
                } else {
                    $data['pos'] = $req->$temp;
                    $data['xy'] = 0;
                }
                $this->exam->publishExam($req->examID, $student_id, $req->subjectID, $data);
            }
            // return json_encode(['ok' => true, 'msg' => "Marks published successfully"]);
            return redirect()->back();
        }

        // return json_encode(['ok' => false, 'msg' => "An error occured"]);
    }
    public function exam_publish_mark(Request $req)
    {
        $existData = $this->exam->getExamMark1($req->exam_id, $req->student_id, $req->my_class_id);
        if ($existData != null) {
            $this->exam->updateExamMark1($req->exam_id, $req->student_id, $req->my_class_id, $req->ps);
        } else {
            $this->exam->insertExamMark1($req->exam_id, $req->student_id, $req->my_class_id, $req->section_id, $req->pos, $req->af, $req->p_comment);
        }
        return redirect('/exams');
    }
    public function exam_delete_mark(Request $req)
    {
        $this->exam->deleteExamMark($req->exam_id, $req->student_id, $req->my_class_id);
        return json_encode(['ok' => true, 'msg' => "Marks deleted successfully"]);
    }
    public function exam_class_upload_mark(Request $req)
    {
        echo $req->subjectID . "<br>";
        echo $req->exam_class_upload_exam . "<br>";
        echo $req->subjectID . "<br>";
        echo $req->subjectID . "<br>";
        echo $req->subjectID . "<br>";
        echo $req->subjectID . "<br>";

        $d['exams'] = $this->exam->all();
        $d['forms'] = $this->my_class->getAllForms();
        $d['myclasses'] = $this->my_class->getAllMyClasses();
        $d['types'] = Qs::getUserType();
        $d['teachers'] = $this->teachers->getAllTeachers();
        $d['grades'] = $this->my_class->allClassTypeWithNotNull();
        $d['subjects'] = $this->my_class->allSubjects();

        $class_exam_count = $req->class_exam_count;
        $data1['name'] = $req->subjectID > 0 ? "Paper" . $req->subjectID : '';
        $data['year'] = date('Y');
        $data['af'] = $req->subjectID;
        $data['exam_id'] = $req->ExamID;
        $data['my_class_id'] = $req->MyClassID;
        $data1['my_class_id'] = $req->MyClassID;
        $data['ps'] = 0;
        $data['p_comment'] = $req->exam_class_upload_max;
        $data1['teacher_id'] = $req->TeacherID;
        if ($data1['name'] == '') return json_encode(['msg' => 'Upload Fail']);
        for ($i = 0; $i < $class_exam_count; $i++) {
            $temp = '';
            $temp = "student" . $i;
            $record = [];
            $data['student_id'] = $req->$temp;
            $temp = "mark" . $i;
            if ($req->$temp == "X") {
                $data['xy'] = 1;
                $data['pos'] = 0;
            } elseif ($req->$temp == "Y") {
                $data['pos'] = 0;
                $data['xy'] = 2;
            } else {
                $data['pos'] = $req->$temp;
                $data['xy'] = 0;
            }
            // return json_encode(['temp'=>$temp, 'data'=>$req->$temp]);
            if ($data['my_class_id'] > 0 && $data1['teacher_id'] && $data1['name'] != '') {
                $curSection = $this->my_class->getClassSection($data1['name']);
                if ($curSection != null) {
                    $data['section_id'] = $curSection->id;
                    array_push($record, $this->exam->createRecord($data));
                    // return json_encode(['record'=>'ok']);
                } else {
                    $section = $this->my_class->createSection($data1);
                    $data['section_id'] = $section->id;
                    array_push($record, $this->exam->createRecord($data));
                    // return json_encode(['record'=>'ok']);
                }
            }
        }
        // echo "===================================>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>";
        // return redirect('/exams');
        // return json_encode(['msg'=>'Upload success', 'exam_reacord'=>$data, 'section'=>$data1, 'record'=>$record]);
    }

    public function exam_class_download()
    {
        $d['exams'] = $this->exam->all();
        $d['forms'] = $this->my_class->getAllForms();
        $d['types'] = Qs::getUserType();
        // return view('pages.support_team.exams.exam_class_upload', $d);
        return json_encode(['msg' => 'download success']);
    }
    public function exam_class_grant()
    {
        $d['exams'] = $this->exam->all();
        $d['forms'] = $this->my_class->getAllForms();
        $d['types'] = Qs::getUserType();
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        return view('pages.support_team.exams.exam_class_grant', $d);
    }

    public function exam_class_detail_view()
    {
        $d['exams'] = $this->exam->all();
        $d['forms'] = $this->my_class->getAllForms();
        $d['types'] = Qs::getUserType();
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        return view('pages.support_team.exams.exam_class_detail_view', $d);
    }
    public function exam_class_score(Request $req)
    {
        $d['exams'] = $this->exam->all();
        $d['forms'] = $this->my_class->getAllForms();
        $d['types'] = Qs::getUserType();
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        return view('pages.support_team.exams.exam_class_detail_view', $d);
    }

    public function admin_publish(Request $req)
    {
        $data = 4;
        $arr = $this->my_class->find_stream_by_formID($req->form_id);
        $stream_id_array = [];
        foreach ($arr as $key => $val) {
            array_push($stream_id_array, $val->id);
        }
        $this->exam->updateflag_new($stream_id_array, $req->exam_id, $data);
        $this->exam->updateflag($req->form_id, $req->exam_id, $data);
        return json_encode(["res" => "ok"]);
    }

    public function unpublish_result(Request $req)
    {
        $arr = $this->my_class->find_stream_by_formID($req->form_id);
        $stream_id_array = [];
        foreach ($arr as $key => $val) {
            array_push($stream_id_array, $val->id);
        }
        $this->exam->updateflag_new($stream_id_array, $req->exam_id, 0);
        $this->exam->updateflag($req->form_id, $req->exam_id, 0);
        return json_encode(["res" => "ok"]);
    }

    public function exam_subject_upload()
    {
        $d['exams'] = $this->exam->all();
        $d['forms'] = $this->my_class->getAllForms();
        $d['types'] = Qs::getUserType();
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        return view('pages.support_team.exams.exam_class_upload', $d);
    }

    public function add_grading_system_id(Request $req)
    {
        $form_id = $req["form_id"];
        $exam_id = $req["exam_id"];
        $new_arr = $req["new_arr"];
        $overal_grading_sys = $req["overal_grading_sys"];
        $streams = $this->my_class->get_streams($form_id);
        foreach ($streams as $stream) {
            $this->exam->update_exam_record($exam_id, $stream->id, $new_arr, $overal_grading_sys);
        }
    }

    public function exam_manage_publish($exam_id, $form_id)
    {
        $d['exams'] = $this->exam->find($exam_id);
        $d['exam_id'] = $exam_id;
        $d['exam'] = $this->exam->find_examform_by_examid_formid($form_id, $exam_id);
        $d['forms'] = $this->my_class->findForm($form_id);
        $d['check_arr'] = $this->exam->check_all_subject_uploaded($exam_id, $d['forms']->my_classes);
        $d['cnt'] = $this->exam->getcnt($form_id, $exam_id);
        $d['grades'] = $this->my_class->allClassTypeWithNotNull();
        $d['types'] = Qs::getUserType();
        $d['subjects'] = $this->my_class->get_streams($form_id);
        $d['subjects_for_Form'] = [];
        foreach ($d['subjects'] as $key => $val) {
            $stream_id = $val->id;
            $subjects = $this->my_class->get_subject_names($stream_id);
            foreach ($subjects as $sub) {
                array_push($d['subjects_for_Form'], $sub->subject->title, $sub->subject->id);
            }
        }
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        return view('pages.support_team.exams.exam_manage_publish', $d);
    }

    public function exam_manage_analysis()
    {
        $d['exams'] = $this->exam->all();
        $d['forms'] = $this->my_class->getAllForms();
        $d['types'] = Qs::getUserType();
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        return view('pages.support_team.exams.exam_manage_analysis', $d);
    }
    public function exam_manage_send()
    {
        $d['exams'] = $this->exam->all();
        $d['forms'] = $this->my_class->getAllForms();
        $d['types'] = Qs::getUserType();
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        return view('pages.support_team.exams.index', $d);
    }
    public function grade_store(Request $req)
    {
        $forms = json_decode($req->formData);
        // $grade_name = $req->gradeName;
        $data1['name'] = $req->gradeName;
        $data1['code'] = $this->user->generateRandomString();
        $class_type = $req->gradeName != null ? $this->my_class->createClassType($data1) : '';
        // $temp = [];
        foreach ($forms as $form) {
            // $data['id'] = $form->id;
            $data['mark_from'] = $form->low;
            $data['mark_to'] = $form->high;
            $data['name'] = $form->name;
            $data['remark'] = $form->remark;
            if ($class_type != '') {
                $data['class_type_id'] = $class_type->id;
                $grades = $this->exam->createGrade($data);
            } else {
                $this->exam->updateGrade($form->id, $data);
                // array_push($temp, $t);
            }
        }

        return json_encode(['ok' => true, 'msg' => "Created Successfully", 'data' => $forms]);
    }
    public function class_index_test(Request $req)
    {
        echo $req->examval;
    }

    public function exam_manage_send_msg(Request $req)
    {
        $d['exams'] = $this->exam->all();
        $d['forms'] = $this->my_class->getAllForms();
        $d['types'] = Qs::getUserType();
        $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        return view('pages.support_team.exams.exam_manage_send', $d);
    }
    public function class_index(Request $req)
    {
        // return json_encode(['exams' => 'controller empty value for test']);
        $d['exams'] = $this->exam->all();
        $d['forms'] = $this->my_class->getAllForms();
        $d['teacher'] = $this->teachers->findTeacherbyUserID(Qs::getUserID());
        $d['examid'] = $this->exam->getformID($req['exam']);
        $d['teacher_name'] = $d['teacher']['user']['name'];
        $d['class_subject'] = $this->my_class->getClassSubjectByTeacher($d['teacher']->id);
        // var_dump($d['teacher_name']);
        // return;
        $last = $this->exam->last();
        // return json_encode(['teacher'=>$d['teacher_name']]);
        if ($req->exam > 0) {
            $d['myclasses'] = $this->my_class->getClassByExam($req->exam);
            $d['myclasses1'] = $this->my_class->getAllMyExam1();
            $d['streams'] = $this->my_class->getClassByExamStream($req->exam);
            // $d['myclasses'] = $this->my_class->getClassByTeacher($req->exam);
            // $d['class_subjects'] = $this->my_class->findSubjectByTeacher($req->teacher);
        } else {
            // $d['myclasses'] = $this->my_class->getAllMyExam($last);
            $d['myclasses'] = $this->my_class->getClassByExam($last);
            $d['myclasses1'] = $this->my_class->getAllMyExam1();
            $d['streams'] = $this->my_class->getAllMyExamStream();
            // $d['myclasses'] = $this->my_class->getAllMyClasses();
            // $d['class_subjects'] = $this->my_class->allSubject();
        }
        $d['all_myclasses'] = $this->my_class->getAllMyClasses();
        $d['types'] = Qs::getUserType();
        $d['teachers'] = $this->teachers->getAllTeachers();
        // echo $req->teacher;
        // return view('pages.support_team.exams.index', $d);

        return json_encode(['exams' => $d['exams'], 'my_class_subject' => $d['class_subject'], 'teacher_name' => $d['teacher_name'], 'all_myclasses' => $d['all_myclasses'], 'last' => $last, 'forms' => $d['forms'], 'myclasses' => $d['myclasses'], 'myclasses1' => $d['myclasses1'], 'types' => $d['types'], 'teachers' => $d['teachers'], 'teacher' => $d['teacher'], 'streams' => $d['streams']]);
    }

    public function grant_access_to_subject_teachers(Request $req)
    {
        $data['is_upload'] = 0;
        foreach ($req->arr as $per_arr) {
            $this->exam->grant_access_to_subject($per_arr['exam_id'], $per_arr['myclass_id'], $per_arr['subject_id'], $data);
        }
    }

    public function stream_publish(Request $req)
    {
        $exam_id = $req->exam_id;
        $my_class_id = $req->class_id;
        $data['flag'] = 2;
        $this->exam->stream_publish($exam_id, $my_class_id, $data);
    }

    public function exam_stream_view($teacher_id, $myclass_id, $exam_id)
    {

        // teacher,class_subject,students,form tables are including
        $d['myclass'] = $this->my_class->getClassAll($myclass_id);
        $d['exam'] = $this->exam->find($exam_id);
        $d['exam_id'] = $exam_id;
        $d['myclass_id'] = $myclass_id;
        $d['exam_records'] = $this->exam->get_examrecord_by_examid($exam_id, $myclass_id);
        // echo $d['myclass']->class_subject[1]->subject->exam_record;exit();
        $d['types'] = Qs::getUserType();
        return view('pages.support_team.exams.exam_stream_view', $d);
    }

    public function supervisor_publish_mark(Request $req)
    {
        $exam_id = $req->exam_id;
        $form_id = $req->form_id;
        $data['flag'] = 3;
        $class = $this->my_class->getClass($form_id);
        $this->exam->publish_by_supervisor($class, $exam_id, $data);
    }

    public function exam_form_view($form_id)
    {
        $d['form'] = $this->exam->getForm($form_id);
        $d['stream'] = $this->my_class->getClass($form_id);
        $d['types'] = Qs::getUserType();
        $d['exams'] = $this->exam->all();
        $d['last'] = $this->exam->last();
        $d['form_id'] = $form_id;
        return view('pages.support_team.exams.exam_form_view', $d);
    }

    public function exam_index(Request $req)
    {
        if ($req->year > 1) {
            $exams = $this->exam->allByYear($req->year);
        } else {
            $exams = $this->exam->all();
        }
        $terms = $this->exam->terms();
        $forms = $this->my_class->getAllForms();
        $examforms = $this->exam->getAllExamForms();
        $deleteds = $this->exam->getAllExamFormsByDeleted();
        $grades = $this->my_class->allClassTypeWithNotNull();
        $myClasses = $this->my_class->getAllMyClasses();
        $exam_records = $this->my_class->getAllMyExam1();
        $marks = $this->mark->all();
        $teachers = $this->teachers->getAllTeachers();
        $user = Qs::getUserName();
        return json_encode([
            'exams' => $exams, "exam_records" => $exam_records,  'forms' => $forms, 'examforms' => $examforms,
            'marks' => $marks, 'terms' => $terms, 'myclasses' => $myClasses, 'teachers' => $teachers, 'grades' => $grades, 'deleteds' => $deleteds, 'user' => $user
        ]);
    }

    public function examResults(Request $request)
    {

        $std_res = array();
        $exams = $this->exam->getExamByForm($request->form_id);
        foreach ($exams as $key => $val) {
            array_push($std_res, array(
                'id' => $val->exam_id,
                'name' => $val->exam->name . 'of term ' . $val->exam->term . ' , ' . $val->exam->year,
                // 'adm_no' => $val->adm_no,
                // 'user_id' => $val->user_id,
            ));
        }
        return json_encode($std_res);
    }

    public function storeExamForm(Request $req)
    {
        // print_r($req);
        $data['exam_id'] = $req->exam_id;
        $forms = json_decode($req->forms, false);
        foreach ($forms as $form) {
            $data['form_id'] = $form->id;
            $data['state'] = 0;
            $data['min_subject_cnt'] = $form->cnt;
            $examform = $this->exam->createExamForm($data);
        }
        return json_encode(['ok' => true, 'msg' => "Created Successfully"]);
    }
    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'exam_type' => 'required|string',
            'exam_name' => 'required|string',
            'exam_term' => 'required|numeric',
            'exam_year' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $data['type'] = $req->exam_type;
        $data['name'] = $req->exam_name;
        $data['term'] = $req->exam_term;
        $data['year'] = $req->exam_year;
        if (!$exam = $this->exam->isExist($data)) {

            $exam = $this->exam->create($data);

            $exam_forms = json_decode($req->exam_forms);

            foreach ($exam_forms as $value) {

                $data2['exam_id'] = $exam->id;
                $data2['form_id'] = $value->form_id;
                $data2['min_subject_cnt'] = $value->min_subject_cnt;
                $data2['state'] = false;
                $this->exam->createExamForm($data2);
                // return json_encode(['data'=>$data2]);
            }
            return json_encode(['ok' => true, 'msg' => "Created Successfully"]);
        }
        return json_encode(['ok' => true, 'msg' => "Already Exist"]);
    }

    public function exam_update(Request $req)
    {

        $data['name'] = $req->name;
        $data['type'] = $req->type;
        $data['term'] = $req->term;
        $data['year'] = $req->year;
        $res = $this->exam->update($req->id, $data);
        if ($res) return json_encode(['ok' => true, 'msg' => "Updated Successfully"]);
        return json_encode(['ok' => true, 'msg' => "An error occured"]);
    }
    public function exam_delete(Request $req)
    {
        // return json_encode(['data' => $req->id]);
        $res = $this->exam->delete($req->id);
        if ($res) return json_encode(['ok' => true, 'msg' => "Deleted Successfully"]);
        return json_encode(['ok' => false, 'msg' => "An error occured"]);
    }
    public function exam_final_delete(Request $req)
    {
        // return json_encode(['data' => $req->id]);
        $res = $this->exam->each_delete_final($req->exam_id, $req->form_id);
        if ($res) return json_encode(['ok' => true, 'msg' => "Deleted Successfully"]);
        return json_encode(['ok' => false, 'msg' => "An error occured"]);
    }
    public function exam_final_recover(Request $req)
    {
        // return json_encode(['data' => $req->id]);
        $res = $this->exam->each_delete_recover($req->exam_id, $req->form_id);
        if ($res) return json_encode(['ok' => true, 'msg' => "Deleted Successfully"]);
        return json_encode(['ok' => false, 'msg' => "An error occured"]);
    }
    public function grade_delete(Request $req)
    {
        // return json_encode(['data' => $req->id]);
        $res = $this->exam->deleteGradeByClassTypeID($req->class_type_id);
        if ($res) return json_encode(['ok' => true, 'msg' => "Deleted Successfully"]);
        return json_encode(['ok' => false, 'msg' => "An error occured"]);
    }

    public function each_exam_delete(Request $req)
    {
        // return json_encode(['exam' => $req->exam_id, 'form'=>$req->form_id, 'ok' => true]);
        $res = $this->exam->each_delete($req->exam_id, $req->form_id);
        if (!$res) return json_encode(['ok' => true, 'msg' => "Deleted Successfully"]);
        return json_encode(['ok' => false, 'msg' => "An error occured"]);
    }
}
