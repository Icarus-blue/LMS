<?php

namespace App\Imports;

use App\User;
use App\Models\Student;
use App\Models\MyClass;
use App\Models\Form;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Helpers\Qs;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;

class StudentTempImport implements ToCollection
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */


    public function collection(Collection $rows)
    {
        $i = 0;
        foreach ($rows as $row) {
            $i++;
            if ($i == 1) {
                continue;
            } else {
                $default_password = 'qwerQWER1234!@#$_student';
                $user = Student::where('adm_no', $row[0])->first();
                if (count($row) == 5 && $user == null) {
                    $user = User::create([
                        'name'     => $row[1],
                        'email'  => substr($row[1], 0, 12) . "@bibirionihigh",
                        "password" => $default_password,
                        'gender'     => "male",
                        "user_type_id" => 4,
                        'code' => $this->generateRandomString(),
                        'password' => Hash::make($default_password),
                    ]);
                    $formname = $row[3];
                    $stream_name = $row[4];
                    $form_id = Form::where("name", $formname)->first()->id;
                    $my_class_id = MyClass::where(["form_id" => $form_id, "stream" => strtolower($stream_name)])->first()->id;
                    $student = Student::create([
                        "user_id" =>  $user->id,
                        "adm_no" => $row[0],
                        "my_class_id" => $my_class_id
                    ]);
                } else {

                }
            }
        }
    }


    public function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
