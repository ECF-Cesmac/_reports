<?php

require_once('../config.php');

// function lastAccessOfTeachersOfTheCourses() {
//     global $DB;
//     $sql = "SELECT u.id, ul.id, u.firstname, c.fullname, cct.name, ul.timeaccess
//             FROM {user_lastaccess} AS ul
//             JOIN {user} AS u
//             ON ul.userid=u.id 
//             JOIN {course} AS c
//             ON ul.courseid=c.id
//             JOIN {course_categories} AS cct
//             ON c.category=cct.id 
//             JOIN {role_assignments} AS ra
//             ON ra.userid=u.id
//             JOIN {context} AS cc
//             ON cc.instanceid=c.id
//             WHERE (cc.contextlevel=:contextlevel AND ra.roleid=:roleid)
//             ORDER BY u.firstname ASC";
// 
//     $params = array('contextlevel' => 50, 'roleid' => 4);
//     return $DB->get_records_sql($sql, $params);
// };

function lastAccessOfTeachersOfTheCourses() {
    global $DB;
    $sql = "SELECT u.id, ul.id, u.firstname, c.fullname, cct.name, ul.timeaccess
            FROM {user_lastaccess} AS ul
            JOIN {user} AS u
            ON ul.userid=u.id 
            JOIN {course} AS c
            ON ul.courseid=c.id
            JOIN {course_categories} AS cct
            ON c.category=cct.id 
            JOIN {role_assignments} AS ra
            ON ra.userid=u.id
            JOIN {context} AS cc
            ON cc.instanceid=c.id
            WHERE (cc.contextlevel=:contextlevel AND u.id=:id)
            ORDER BY ul.timeaccess DESC LIMIT 25";

    $params = array('contextlevel' => 50, 'id' => 2);
    return $DB->get_records_sql($sql, $params);
};
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Internal Reports</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<pre>
<?php //print_r(lastAccessOfTeachersOfTheCourses());?>
</pre>
    <div class="container">
      <!-- Content here -->
        <header >
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand" href="#">Último acesso dos tutores aos cursos</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
        </header>
        <table class='table table-sm table-bordered table-striped table-dark'>
            <thead>
                <tr>
                    <th class="text-center" scope="col">Tutor</th>
                    <th class="text-center" scope="col">Disciplina</th>
                    <th class="text-center" scope="col">Curso</th>
                    <th class="text-center" scope="col">Último Acesso</th>
                    <th class="text-center" scope="col">Intervalo de dias</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach( lastAccessOfTeachersOfTheCourses() as $access ):?>
                <tr>
                    <td><?php echo $access->firstname;?></td>
                    <td><?php echo $access->fullname;?></td>
                    <td><?php echo $access->name;?></td>
                    <td class="text-center" ><?php echo date('d/m/Y H:i:s',$access->timeaccess);?></td>
                    <td class="text-center" ><?php echo strtotime("now");?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
</body>
</html>
