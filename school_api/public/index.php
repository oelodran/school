<?php
require_once('../includes/initialize.php');

if($_SERVER['REQUEST_METHOD'] == "GET")

{
   if ($_GET['url'] == "student")
   {
       if (($_GET['student']=="all") && isset($_GET['token']))
       {
           $token = $_GET['token'];
           $students = Students::find_all();
           if ($students && Token::compareTokens($token))
           {
               $allStudents = array();
               foreach ($students as $student)
               {
                   $allStudents[] = $student;
               }
               print json_encode($allStudents);
           }
           else
           {
               http_response_code(400);
           }
       }

   }
   elseif ($_GET['url'] == "grade")
   {
       if (($_GET['grade']=="all") && isset($_GET['token']))
       {
           $token = $_GET['token'];
           $grades = Grade::find_all();
           if ($grades && Token::compareTokens($token))
           {
               $allGrades = array();
               foreach ($grades as $grade)
               {
                   $allGrades[] = $grade;
               }
               print json_encode($allGrades);
           }
           else
           {
               http_response_code(400);
           }
       }
       elseif (isset($_GET['grade']) && isset($_GET['token']))
       {
           $token = $_GET['token'];
           $grade = $_GET['grade'];

           $students = Students::studentsFromGrade($grade);
           if ($students && Token::compareTokens($token))
           {
               $allStudents = array();
               foreach ($students as $student)
               {
                   $allStudents[] = $student;
               }
               print json_encode($allStudents);
           }
           else
           {
               http_response_code(400);
           }
       }
   }
}
elseif ($_SERVER['REQUEST_METHOD'] == "POST")
{
    if ($_GET['url'] == "auth")
    {
        Token::auth();
    }

    if ($_GET['url'] == "student")
    {
        if (($_GET['student']=="create") && isset($_GET['token']))
        {
            $token = $_GET['token'];

            if (Token::compareTokens($token))
            {
                $postBody = file_get_contents("php://input");
                $postBody = json_decode($postBody);
                print_r($postBody);

                $class_id    = $postBody->class_id;
                $first_name  = $postBody->first_name;
                $last_name   = $postBody->last_name;

                $student = new Students();

                $student->class_id   = $class_id;
                $student->first_name = $first_name;
                $student->last_name  = $last_name;

                $student->create();

                echo "Successfully add student: " . $student->first_name;
            }
            else
            {
                http_response_code(405);
            }
        }
        else
        {
            echo '{ "Error": "Malformed request" }';
            http_response_code(400);
        }
    }
}
elseif ($_SERVER['REQUEST_METHOD'] == "PUT")
{
    if ($_GET['url'] == "student")
    {
        if (isset($_GET['id']) && isset($_GET['token']))
        {

            $token = $_GET['token'];
            $id = $_GET['id'];
            $student = Students::find_by_id($_GET['id']);

            if ($student && Token::compareTokens($token))
            {
                $postBody = file_get_contents("php://input");
                $postBody = json_decode($postBody);
                print_r($postBody);

                $class_id = $postBody->class_id;
                
                var_dump($student);
                $student->class_id = $class_id;

                $student->update();

                echo "Successfully replace student: " . $student->first_name;
            }
            else
            {
                http_response_code(405);
            }
        }
        else
        {
            echo '{ "Error": "Malformed request" }';
            http_response_code(400);
        }
    }
}
elseif ($_SERVER['REQUEST_METHOD'] == "DELETE")
{
    if ($_GET['url'] == "auth")
    {
        if (isset($_GET['token']))
        {
            $token = $_GET['token'];
            echo 'token: ' . $token . '<br>';

            if (Token::compareTokens($token))
            {
                Token::deleteToken($token);
                echo '{ "Status": "Success" }';
                http_response_code(200);
            }
            else
            {
                echo '{ "Error": "Invalid token" }';
                http_response_code(400);
            }
        }
        else
        {
            echo '{ "Error": "Malformed request" }';
            http_response_code(400);
        }
    }
    elseif ($_GET['url'] == 'student')
    {
        if (isset($_GET['id']) && isset($_GET['token']))
        {
            $token = $_GET['token'];
            $id = $_GET['id'];
            $student = Students::find_by_id($_GET['id']);
            if ($student && Token::compareTokens($token) && $student->delete())
            {
                echo "The student " . $student->first_name . " is deleted.";
            }
            else
            {
                echo "The book could not be deleted.";
                http_response_code(400);
            }
        }
    }
    elseif ($_GET['url'] == 'grade')
    {
        $token = $_GET['token'];
        $id = $_GET['id'];
        $grade = Grade::find_by_id($_GET['id']);
        if ($grade && Token::compareTokens($token) && $grade->delete())
        {
            echo "The grade " . $grade->name . " is deleted.";
        }
        else
        {
            echo "The grade could not be deleted.";
            http_response_code(400);
        }
    }
    elseif ($_GET['url'] == 'mark')
    {
        $token = $_GET['token'];
        $id = $_GET['id'];
        $mark = Marks::find_by_id($_GET['id']);
        if ($mark && Token::compareTokens($token) && $mark->delete())
        {
            echo "The mark " . $mark->mark . " is deleted.";
        }
        else
        {
            echo "The mark could not be deleted.";
            http_response_code(400);
        }
    }
    elseif ($_GET['url'] == 'subject')
    {
        $token = $_GET['token'];
        $id = $_GET['id'];
        $subject = Subject::find_by_id($_GET['id']);
        if ($subject && Token::compareTokens($token) && $subject->delete())
        {
            echo "The subject " . $subject->title . " is deleted.";
        }
        else
        {
            echo "The subject could not be deleted.";
            http_response_code(400);
        }
    }
    elseif ($_GET['url'] == 'teacher')
    {
        $token = $_GET['token'];
        $id = $_GET['id'];
        $teacher = Subject::find_by_id($_GET['id']);
        if ($teacher && Token::compareTokens($token) && $teacher->delete())
        {
            echo "The teacher " . $teacher->first_name . " is deleted.";
        }
        else
        {
            echo "The teacher could not be deleted.";
            http_response_code(400);
        }
    }
}
else
{
    http_response_code(405);
}