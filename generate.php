<?php
/**
 * Created by PhpStorm.
 * User: quyentruong
 * Date: 6/9/16
 * Time: 12:47 PM
 */
define("maxvalue", 5);
function mysql_connection()
{
    $password = "XXX";
    $dsn = 'mysql:dbname=usCitizenTest;host=vergil.u.washington.edu;port=XXX;
        charset=utf8';
    return new PDO($dsn, "root", $password);
}

function generate_choices()
{

    // connect to multiple_choices
    try {
        $db = mysql_connection();
    } catch (PDOException $e) {
        die('Could not connect to the database:<br/>' . $e);
    }
    $questions = $db->query("SELECT * FROM questions ORDER BY id"); // get question title
//        $questions = $questions->fetchAll();
//        print_r($questions);
    //    $n = (int)$number_of_questions->fetchColumn();
    //    echo gettype($n);
    $i = 1; ?>
    <div class="container">
        <div class="row">
            <?php
            foreach ($questions as $question) {
                //    for ($i = 0; i < $n; $i++) {
                $letter = array("A", "B", "C", "D", "E");
                $id = $db->quote($i);
                // choice for English
                // choice_vi for Vietnamese
                $choices = $db->query("SELECT CONCAT(answer_id,choice_vi) AS chs FROM choices
                                                WHERE question_id = $id");
                $choices = $choices->fetchAll(); // object -> array

                shuffle($choices); ?>
                <div class="btn-group btn-group-vertical col-lg-12 col-md-12 col-sm-12 col-xs-12" data-toggle="buttons">

                    <h2 id="q_en" class="question_class"><?= $i . ") " .
                        // question for English
                        // question_vi for Vietnamese
                        $question["question_vi"]
                        ?>
                        <!-- speaker -->
                        <audio class="audio" src="<?= $question["audio"] ?>"></audio>
                        <button name="play_<?= $i - 1 ?>" type="button" class="btn btn-info play_audio"><span
                                class="glyphicon glyphicon-volume-up"></span>
                        </button>
                    </h2>

                    <?php
                    $j = 0;
                    foreach ($choices as $choice) {
                        $q_id = substr($choice["chs"], 0, 1); // this is the answer id
                        $ch = substr($choice["chs"], 1); // get choice
                        ?>

                        <label class="btn active"><input type="radio"
                                                         name="question-<?= $i ?>-answers"
                                                         value="<?= $q_id . "_" . $question["answer"] ?>"/>
                            <i class="fa fa-circle-o fa-2x"></i>
                            <i class="fa fa-dot-circle-o fa-2x"></i>
                            <?= $letter[$j++] . ") " . $ch
                            ?>
                        </label>

                        <?php
                    }
                    $i++; ?>
                </div>
                <?php
            } ?>
        </div>
    </div>
    <?php
    $db = null;
} ?>




