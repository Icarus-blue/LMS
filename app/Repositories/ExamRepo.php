<?php

namespace App\Repositories;

use App\Models\ClassSubject;
use App\Models\Exam;
use App\Models\ExamForm;
use App\Models\ExamRecord;
use App\Models\Grade;
use App\Models\Mark;
use App\Models\Skill;
use App\Models\Form;
use App\Models\ClassType;
use App\Models\MyClass;
use App\Models\metalist;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Meta;

class ExamRepo
{

    public function all()
    {
        return Exam::orderBy('term', 'asc')->orderBy('created_at', 'desc')->get();
    }

    public function getallsubject()
    {
        return Subject::where()->get();
    }

    public function subject_score_form($value, $exam_id)
    {
        return ExamRecord::where(['af' => $value, 'exam_id' => $exam_id])->get();
    }

    public function getadmno($student_id_each)
    {
        return Student::where('id', $student_id_each)->first();
    }
    public function last()
    {
        $exam = Exam::orderBy('term', 'desc')->orderBy('created_at', 'desc')->first();
        if ($exam == null) {
            return false;
        } else {
            return $exam->id;
        }
    }
    public function examrecords_by_examid_streamid_subject_id($exam_id, $streamid, $value)
    {
        return ExamRecord::where(['exam_id' => $exam_id, 'my_class_id' => $streamid, 'af' => $value])->get();
    }

    public function exam_records($exam_id, $my_class_id)
    {
        return ExamRecord::where(['exam_id' => $exam_id, 'my_class_id' => $my_class_id])->get();
    }
    public function metalisttable($stream_id)
    {
        return metalist::where(['stream_id' => $stream_id])->get();
    }
    public function subject_name($val)
    {
        return Subject::where('id', $val)->first();
    }

    public function students_subject($exam_id, $value)
    {
        return ExamRecord::where(['exam_id' => $exam_id, "af" => $value])->get();
    }

    public function getexamrecords_for_seventh($exam_id)
    {
        return ExamRecord::where('exam_id', $exam_id)->get();
    }

    public function students_stream($exam_id, $stream_id)
    {
        return ExamRecord::where(["exam_id" => $exam_id, "my_class_id" => $stream_id])->get();
    }

    public function student_subject_score($exam_id, $val)
    {
        return ExamRecord::where(["exam_id" => $exam_id, "student_id" => $val])->get();
    }

    public function subject_teacher_name($value, $stream_id)
    {
        return ClassSubject::where(['subject_id' => $value, 'my_class_id' => $stream_id])->with("teacher.user")->get();
    }

    public function records_subject($value, $exam_id)
    {
        return ExamRecord::where(["af" => $value, "exam_id" => $exam_id])->get();
    }

    public function get_grades($overgradingsys)
    {
        return Grade::where("class_type_id", $overgradingsys)->get();
    }

    public function get_users($val, $stream_id, $exam_id)
    {
        return ExamRecord::where(['exam_id' => $exam_id, 'my_class_id' => $stream_id, 'af' => $val])->get();
    }

    public function get_exam_by_id($exam_id)
    {
        return Exam::where("id", $exam_id)->get();
    }

    public function get_form_by_id($form_id)
    {
        return Form::where("id", $form_id)->get();
    }

    public function get_stream_by_id($stream_id)
    {
        return MyClass::where("id", $stream_id)->get();
    }

    public function create_metalist($new_arr)
    {
        $res = metalist::where(["stream_id" => $new_arr[0], "exam_id" => $new_arr[1], 'adm_no' => $new_arr[2]])->get();
        if (count($res) > 0) {
            return false;
        } else {
            return metalist::create(['stream_id' => $new_arr[0], 'exam_id' => $new_arr[1], 'adm_no' => $new_arr[2], 'Name' => $new_arr[3], 'stream_name' => $new_arr[4], 'subject_name' => $new_arr[5], 'marks_new' => $new_arr[6], 'sbj' => $new_arr[7], 'kcpe' => $new_arr[8], 'vap' => $new_arr[9], 'mn_mks' => $new_arr[10], 'dev' => $new_arr[11], 'over_grad' => $new_arr[12], 'total_mark' => $new_arr[13], 'Total_pts' => $new_arr[14], 'stream_order' => $new_arr[15], 'order_form' => $new_arr[16]]);
        }
    }

    public function get_metalist_from_db($stream_id, $exam_id)
    {
        return metalist::where(["stream_id" => $stream_id, "exam_id" => $exam_id])->get();
    }

    public function get_marks_pre_exam($student_id, $pre_exam_id)
    {
        if (count(ExamRecord::where("exam_id", $pre_exam_id)->get()) > 0) {
            return ExamRecord::where(["exam_id" => $pre_exam_id, "student_id" => $student_id])->get();
        } else {
            return false;
        }
    }

    public function get_stream_id_by_formid($form_id)
    {
        return MyClass::where("form_id", $form_id)->get();
    }

    public function get_all_form()
    {
        return Form::get();
    }
    public function terms()
    {
        return Exam::select('term')->groupBy('term')->orderBy('term', 'desc')->get();
    }

    public function get_examreco_by_id($previous_exam_id, $stream_id)
    {
        return ExamRecord::where(['exam_id' => $previous_exam_id, "my_class_id" => $stream_id])->get();
    }

    public function allByYear($year)
    {
        return Exam::where('year', $year)->orderBy('created_at', 'desc')->orderBy('name', 'asc')->get();
    }
    public function get_num_not_marks($myclass_id, $exam_id)
    {
        return ExamRecord::where(['exam_id' => $exam_id, 'my_class_id' => $myclass_id, 'pos' => NULL])->get();
    }

    public function getExam($data)
    {
        return Exam::where($data)->get();
    }

    public function getAllExamForms()
    {
        return ExamForm::where('state', 0)->get();
    }
    public function getAllExamFormsByDeleted()
    {
        return ExamForm::where('state', 1)->get();
    }
    public function getExamFormsByExamId($exam_id)
    {
        $ccc = ExamForm::where('exam_id', $exam_id)->get();
        $bbb = array();
        $aaa = Form::orderBy('id', 'asc')->get();
        foreach ($aaa as $val) {
            $count = 0;
            foreach ($ccc as $item) {
                if ($item->form_id == $val->id) {
                    $count = 1;
                    break;
                }
            }
            if ($count == 0) {
                array_push($bbb, array(
                    'id' => $val->id,
                    'name' => $val->name,
                ));
            }
        }
        return $bbb;
    }

    public function getformID($exam_id)
    {
        $ccc = ExamForm::where('exam_id', $exam_id)->get();
        return $ccc;
    }

    public function getForm($id)
    {
        return Form::find($id);
    }
    public function find($id)
    {
        return Exam::find($id);
    }
    public function getExamByForm($form_id)
    {
        return ExamForm::where('form_id', $form_id)->get();
    }

    public function find_examform_by_examid_formid($form_id, $exam_id)
    {
        return ExamForm::where(['form_id' => $form_id, "exam_id" => $exam_id])->get();
    }

    public function update_exam_record($exam_id, $stream_id, $new_arr, $overal_grading_sys)
    {
        $data = ExamRecord::where("my_class_id", $stream_id)->get();
        if (count($data) > 0) {
            foreach ($new_arr as $key => $val) {
                if ($key % 2 == 0) {
                    if (count(ExamRecord::where(["exam_id" => $exam_id, "my_class_id" => $stream_id, "af" => $val])->get()) > 0) {
                        ExamRecord::where(["exam_id" => $exam_id, "my_class_id" => $stream_id, "af" => $val])->update(["class_types_id" => $new_arr[$key + 1], "overal_grading_sys" => $overal_grading_sys]);
                    } else {
                        continue;
                    }
                }
            }
        }
    }


    public function publish_by_supervisor($class, $exam_id, $data)
    {
        foreach ($class as $val) {
            ExamRecord::where(['my_class_id' => $val->id, "exam_id" => $exam_id])->update($data);
        }
    }

    public function check_all_subject_uploaded($exam_id, $my_classes)
    {
        $arr[] = [];
        // foreach ($my_classes as $val) {
        //     $rec = ExamRecord::where(['my_class_id' => $val->id, "exam_id" => $exam_id])->get();
        //     $subject_len = count($val->class_subject);
        //     $student_len = count($val->students);
        //     $len = count($rec);
        //     if ($len / $student_len == $subject_len) {
        //         array_push($arr, 1);
        //     } else {
        //         array_push($arr, 0);
        //     }
        // }
        foreach ($my_classes as $val) {
            array_push($arr, 1);
        }
        return $arr;
    }

    public function create($data)
    {
        return Exam::create($data);
    }

    public function createExamForm($data)
    {
        return ExamForm::create($data);
    }

    public function isExist($data)
    {
        return Exam::where('type', $data['type'])->where('name', $data['name'])
            ->where('term', $data['term'])->where('year', $data['year'])->first();
    }

    public function getcnt($form_id, $exam_id)
    {
        return ExamForm::where('form_id', $form_id)->where('exam_id', $exam_id)->get();
    }

    public function updateflag($form_id, $exam_id, $data)
    {
        return ExamForm::where('form_id', $form_id)->where('exam_id', $exam_id)->update(["flag" => $data]);
    }

    public function updateflag_new($arr, $exam_id, $data)
    {
        foreach ($arr as $val) {
            ExamRecord::where('my_class_id', $val)->where('exam_id', $exam_id)->update(["flag" => $data]);
        }
    }

    public function stream_publish($exam_id, $my_class_id, $data)
    {
        return ExamRecord::where('exam_id', $exam_id)->where('my_class_id', $my_class_id)->update($data);
    }

    public function get_students_marks_by_form_id_exam_id($stream_id, $exam_id)
    {
        return ExamRecord::where(["my_class_id" => $stream_id, "exam_id" => $exam_id])->get();
    }

    public function createRecord($data)
    {

        return ExamRecord::firstOrCreate($data);
    }
    public function allExamRecord()
    {
        return ExamRecord::orderBy('created_at', 'desc')->get();
    }
    public function update($id, $data)
    {
        return Exam::find($id)->update($data);
    }

    public function updateRecord($where, $data)
    {
        return ExamRecord::where($where)->update($data);
    }

    public function grant_access_to_subject($exam_id, $myclass_id, $subject_id, $data)
    {
        return ExamRecord::where(['exam_id' => $exam_id, 'my_class_id' => $myclass_id, 'af' => $subject_id])->update($data);
    }

    public function getRecord($data)
    {
        return ExamRecord::where($data)->get();
    }
    public function getGradeRecord()
    {
        return DB::table('exam_records')->select('year', DB::raw('count(id) as counts'), DB::raw('sum(pos) as mean'), DB::raw('sum(af) as mark'))->groupBy('year')->get();
    }
    public function findRecord($id)
    {
        return ExamRecord::find($id);
    }


    public function get_examrecord_by_examid($exam_id, $myclass_id)
    {
        return ExamRecord::where(['exam_id' => $exam_id, 'my_class_id' => $myclass_id])->get();
    }

    public function is_check_published($exam_id, $my_class_id, $subject_id)
    {
        return ExamRecord::where(['exam_id' => $exam_id, 'my_class_id' => $my_class_id, 'af' => $subject_id])->first();
    }

    public function delete($id)
    {
        ExamForm::where('exam_id', $id)->delete();
        return Exam::destroy($id);
    }
    public function each_delete($exam_id, $form_id)
    {
        // ExamForm::where('exam_id', $exam_id)->where('form_id', $form_id)->delete();
        ExamForm::where('exam_id', $exam_id)->where('form_id', $form_id)->update(['state' => 1]);
        if (count(ExamForm::where('exam_id', $exam_id)->get()) == 0) {
            return Exam::destroy($exam_id);
        }
        return false;
        // echo $exam_id;
    }
    public function each_delete_final($exam_id, $form_id)
    {
        ExamForm::where('exam_id', $exam_id)->where('form_id', $form_id)->where('state', 1)->delete();
        if (count(ExamForm::where('exam_id', $exam_id)->get()) == 0) {
            return Exam::destroy($exam_id);
        }
        return null;
        // echo $exam_id;
    }
    public function each_delete_recover($exam_id, $form_id)
    {
        ExamForm::where('exam_id', $exam_id)->where('form_id', $form_id)->update(['state' => 0]);
        if (count(ExamForm::where('exam_id', $exam_id)->get()) == 0) {
            return Exam::destroy($exam_id);
        }
        return null;
        // echo $exam_id;
    }

    /*********** Grades ***************/

    public function allGrades()
    {
        return Grade::orderBy('name')->get();
    }
    public function allGradesWithNoNull($grade_id)
    {
        return Grade::where("class_type_id", $grade_id)->orderBy('remark', 'desc')->get();
    }

    public function getGrade($data)
    {
        return Grade::where($data)->get();
    }

    public function findGrade($id)
    {
        return Grade::find($id);
    }

    public function createGrade($data)
    {
        return Grade::create($data);
    }
    public function updateExamMax($exam_id, $data)
    {
        return ExamRecord::where('exam_id', $exam_id)->update($data);
    }
    public function updateExamMark($id, $mark)
    {
        return ExamRecord::find($id)->update(['pos' => $mark]);
    }
    public function updateExamMark1($exam_id, $student_id, $class_id, $subject_id, $data)
    {
        return ExamRecord::where(['exam_id' => $exam_id, 'student_id' => $student_id, 'my_class_id' => $class_id, "af" => $subject_id])->update($data);
    }
    public function insertExamMark1($exam_id, $student_id, $class_id, $section_id, $pos, $af, $p_comment)
    {
        return ExamRecord::create(['exam_id' => $exam_id, 'student_id' => $student_id, 'my_class_id' => $class_id, 'section_id' => $section_id, 'pos' => $pos, 'af' => $af, 'ps' => 0, 'p_comment' => $p_comment, 'year' => date('Y')]);
    }
    public function getExamMark1($exam_id, $student_id, $class_id)
    {
        return ExamRecord::where(['exam_id' => $exam_id, 'student_id' => $student_id, 'my_class_id' => $class_id])->first();
    }
    public function deleteExamMark($exam_id, $student_id, $class_id)
    {
        return ExamRecord::where(['exam_id' => $exam_id, 'student_id' => $student_id, 'my_class_id' => $class_id])->delete();
    }
    public function publishExam($exam_id, $student_id, $subjectID, $data)
    {
        return ExamRecord::where(['exam_id' => $exam_id, 'student_id' => $student_id, 'af' => $subjectID])->update($data);
    }
    public function updateGrade($id, $data)
    {
        $grades = Grade::all();
        $flag = 0;
        foreach ($grades as $key => $grade) {
            if ($grade->id == $id) {
                $flag = 1;
                break;
            }
        }
        if ($flag > 0) {
            return Grade::find($id)->update($data);
        } else {
            return Grade::create($data);
        }
        // return $flag;

    }

    public function deleteGrade($id)
    {
        return Grade::destroy($id);
    }
    public function deleteGradeByClassTypeID($class_type_id)
    {
        Grade::where('class_type_id', $class_type_id)->delete();
        return ClassType::destroy($class_type_id);
    }

    /*********** Marks ***************/

    public function createMark($data)
    {
        return Mark::firstOrCreate($data);
    }

    public function destroyMark($id)
    {
        return Mark::destroy($id);
    }

    public function updateMark($id, $data)
    {
        return Mark::find($id)->update($data);
    }

    public function getExamYears($student_id)
    {
        return Mark::where('student_id', $student_id)->select('year')->distinct()->get();
    }

    public function getMark($data)
    {
        return Mark::where($data)->with('grade')->get();
    }

    /*********** Skills ***************/

    public function getSkill($where)
    {
        return Skill::where($where)->orderBy('name')->get();
    }

    public function getSkillByClassType($class_type = NULL, $skill_type = NULL)
    {
        return ($skill_type)
            ? $this->getSkill(['class_type' => $class_type, 'skill_type' => $skill_type])
            : $this->getSkill(['class_type' => $class_type]);
    }
}
