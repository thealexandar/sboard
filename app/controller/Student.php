<?php
    Class Student extends Controller {
        public function __construct(){
            // call student model class
            $this->studentModel = $this->model('StudentModel');
            
        }
        public function index(){
            // get student id parameter from URL
            if(isset($_GET['student'])){
                $student = $_GET['student'];
            }
            // get student details
            $student = $this->studentModel->showStudentGrades($student);
            // convert student grades from string to array
            // (they are in string format due to GROUP_CONCAT function in mysql query)
            $studentGrades = explode(',', $student->grades);
            $sum = 0;
            $result = 'Fail!';
            // sum the grades and calculate the average
            foreach($studentGrades as $grade){
                $sum += $grade;
            }
            $average = $sum / count($studentGrades);
            // if the student school board is = CSM
            if($student->school_id == 1){
                if($average >= 7){
                    $result = 'Pass!';
                }   
                
                $data = [
                   'student_id'     => $student->id_student,
                   'student_name'   => $student->name,
                   'grades'         => $student->grades,
                   'average_grade'  => (int)$average,
                   'result'         => $result,
                ];
                print_r(json_encode($data));
               
            } else if ($student->school_id == 2){ // if the student school board is = CSMB
                // discard the lowest grade
                // count the average
                if(count($studentGrades) > 1){
                    $LowestStudentGrade = min($studentGrades);
                    $total = array_sum($studentGrades) - $LowestStudentGrade;
                    $average = $total / (count($studentGrades) - 1);
                }
                if (($key = array_search($LowestStudentGrade, $studentGrades)) !== false) {
                    unset($studentGrades[$key]);
                }
                // convert array to string
                $student->grades = implode(",", $studentGrades);
                $average = (int)$average;
                if($average > 8){
                    $result = 'Pass!';
                }
             
                $data = [
                   'student_id'     => $student->id_student,
                   'student_name'   => $student->name,
                   'grades'         => $student->grades,
                   'average_grade'  => $average,
                   'result'         => $result,
                ];
                print_r($this->getXmlData($data));
            }

        }

        public function getXmlData(Array $data, $root = 'student'){
            header('Content-Type: application/xml; charset=utf-8');
            $xml = '';
            $xml .= "<?xml version=\"1.0\"?>\n";
            if($root!==null){
                $xml .= "<{$root}>\n";
            }
            foreach ($data as $key=>$value){
                $xml .= "<{$key}>". htmlspecialchars(trim($value))."</{$key}>\n";
            }
            if($root!==null){
                $xml .= "\n</{$root}>\n";
            }
            return $xml;
        }

    }