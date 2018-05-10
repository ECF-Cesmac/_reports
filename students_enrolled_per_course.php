<?php

require_once('../config.php');

function getCoursesAndCategories() {
    global $DB;
    $sql = "SELECT cc.id, cc.name, c.id, c.fullname
            FROM {course_categories} AS cc
            INNER JOIN {course} AS c
            ON c.category = cc.id
            WHERE cc.id > 14 ORDER BY cc.name ASC";

    return $DB->get_records_sql($sql);

};

function getEnrolledPerCourses($courseId) {
    global $DB;
    $sql = "SELECT COUNT(*)
            FROM {role_assignments} rs
            INNER JOIN {user} u
            ON u.id=rs.userid
            INNER JOIN {context} e
            ON rs.contextid=e.id
            WHERE e.contextlevel=50
            AND rs.roleid=5
            AND e.instanceid=?";

    return $DB->get_record_sql($sql, array($courseId));

};

$countEnroll = 0;
$countEnrollCategory = 0;
$categoryId = 0;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Internal Reports</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
      <!-- Content here -->
        <header >
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand" href="#">Matriculados por curso</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
        </header>
        <table class='table table-sm table-bordered table-striped table-dark'>
            <thead>
                <tr>
                    <th class="text-center" scope="col">Cursos</th>
                    <th class="text-center" scope="col">Disciplinas</th>
                    <th class="text-center" scope="col">matriculas na disciplina</th>
                    <th class="text-center" scope="col">matriculas no curso</th>
                </tr>
            </thead>
            <tbody>
    <?php foreach( getCoursesAndCategories() as $course ):?>
                <tr>
                    <th scope="row"><?php echo $course->name; ?></th>
                    <td><?php echo $course->fullname; ?></td>
                    <td class="text-center"><?php echo getEnrolledPerCourses($course->id)->count; ?></td>
                <?php if ( $course->id !== $categoryId ):?>V
                    <td class="text-center"><?php echo getEnrolledPerCourses($course->id)->count; ?></td>
                <?php $categoryId = course->id; ?>
                <?php else: ?>

                <?php endif;?>
                </tr>
    <?php $countEnroll += getEnrolledPerCourses($course->id)->count; ?>
    <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center" colspan="2" scope="col" >Total matriculas nas DOL</th>
                    <th class="text-center" scope="col" ><?php echo $countEnroll?></th>
                </tr>
            </tfoot>
        </table>
    </div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
</body>
</html>


