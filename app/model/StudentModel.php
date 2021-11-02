<?php
    class StudentModel {
        public function __construct(){
            $this->db = new Database;
        }

        public function showStudentGrades($id){
            $this->db->query("SELECT student.*, GROUP_CONCAT(grade.grade) as grades, school.*
                                FROM student
                                JOIN grade ON student.id_student = grade.student_id
                                JOIN school ON student.school_id = school.id_school
                                WHERE id_student = :id
                            ");
            $this->db->bind(':id', $id);
            $row = $this->db->single();
            return $row;
        }

        public function schoolBoard(){
            $this->db->query("SELECT * FROM school");
            $rows = $this->db->resultSet();
            return $rows;
        }
    }