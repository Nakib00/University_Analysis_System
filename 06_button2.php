<!-- Include navbar -->
<?php include('navbar.php') ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include CSS  -->
    <?php include('CSS/style.php') ?>
    <!-- Include Table CSS -->
    <?php include('CSS/Table_css.php') ?>
    <!-- Dropdown CSS  -->
    <?php include('CSS/dropdown.php') ?>
    <title>TCMS</title>
</head>

<body>

    <!-- Animation of the page -->
    <section class="home-section">
        <!-- Admin nav add  -->
        <?php include('AdminNav.php') ?>

        <!-- Titale of the page -->
        <div class="home-content">
            <div class="titlel">
                <H2>students Enrollment</H2>
            </div>
        </div>

        <!-- Table showing  -->
        <div class="home-content">
            <!-- add table -->
            <table class="button6">
                <?php

                // Data get from form 
                $semister1 = $_GET["semister1"];
                $semister2 = $_GET["semister2"];
                $semister_year1 = $_GET["semister_year1"];
                $semister_year2 = $_GET["semister_year2"];
                echo "<tr><th></th><th></th><th></th>
                        <th>" . "$semister1" . " " . "$semister_year1" . "</th><th></th><th></th><th></th><th></th>
                        <th>" . "$semister2" . " " . "$semister_year2" . "</th><th></th><th></th>
                    </tr>
                    <tr>
                    <tr>
                        <th>Enrolment</th>
                        <th>SBE</th>
                        <th>SELS</th>
                        <th>SETS</th>
                        <th>SLASS</th>
                        <th>Total</th>
                        <th>SBE</th>
                        <th>SELS</th>
                        <th>SETS</th>
                        <th>SLASS</th>
                        <th>Total</th>
                    </tr>";



                //Connect with the database
                include('DataBase/connection.php');

                if ($conn->connect_errno) {
                    die("Error connecting" . $conn->connect_error);
                }

                //USE the SQL query Here
                // SELECT COUNT(*) FROM section_t  WHERE school_title= 'SELS' AND  semester_name='spring'AND std_enrolled =2;";
                $school_name = array('SBE', 'SELS', 'SETS', 'SLASS');
                $enrolled_spring = array();
                $total_spring = array();
                $enrolled_summer = array();
                $total_summer = array();

                for ($i = 1; $i <= 60; $i++) {
                    //SPRING
                    for ($j = 0; $j < 4; $j++) {
                        $sql = "SELECT COUNT(*) FROM section_t WHERE school_title= '$school_name[$j]' AND semester_name='$semister1' AND semester_year='$semister_year1' AND std_enrolled ='$i';";
                        $results = $conn->query($sql);
                        if ($results->num_rows > 0) {
                            while ($row = $results->fetch_assoc()) {
                                $enrolled_spring[] = implode(" ", $row);
                            }
                        }
                    }
                    // //SUMMER
                    for ($l = 0; $l < 4; $l++) {
                        $sql2 = "SELECT COUNT(*) FROM section_t WHERE school_title= '$school_name[$l]' AND semester_name='$semister2' AND semester_year='$semister_year2' AND std_enrolled ='$i';";
                        $results2 = $conn->query($sql2);
                        if ($results->num_rows > 0) {
                            while ($row = $results2->fetch_assoc()) {
                                $enrolled_summer[] = implode(" ", $row);
                            }
                        }
                    }
                }

                //spring sum
                $s = 0;
                for ($i = 1; $i <= 60; $i++) {
                    $sum = 0;
                    for ($j = $s; $j < ($s + 4); $j++) {
                        $sum = $sum + $enrolled_spring[$j];
                    }
                    $total_spring[$i] = $sum;
                    $s = $s + 4;
                }

                //summer sum
                $t = 0;
                for ($i = 1; $i <= 60; $i++) {
                    $sum_summer = 0;
                    for ($j = $t; $j < ($t + 4); $j++) {
                        $sum_summer = $sum_summer + $enrolled_summer[$j];
                    }
                    $total_summer[$i] = $sum_summer;
                    $t = $t + 4;
                }

                // print
                $r = 0;
                for ($i = 1; $i <= 60; $i++) {
                    echo "<tr><td>" . $i . "</td>";
                    for ($j = $r; $j < ($r + 4); $j++) {
                        echo "<td>" . $enrolled_spring[$j] . "</td>";
                    }

                    echo "<td>" . $total_spring[$i] . "</td>";

                    for ($k = $r; $k < ($r + 4); $k++) {
                        echo "<td>" . $enrolled_summer[$k] . "</td>";
                    }

                    echo "<td>" . $total_summer[$i] . "</td></tr>";
                    $r = $r + 4;
                }
                echo "</table>";

                $conn->close();

                ?>

            </table>
        </div>
    </section>

    <!-- JavaScript add -->
    <?php include('javascript/javascript.php') ?>

</body>

</html>