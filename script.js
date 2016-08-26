(function () {
    "use strict";
    var list = [];
    var num_question;
    var correct_num = 0;
    window.onload = function () {
        // Select language english or vietnamese
        document.getElementById("select_language").onchange = select_language;

        // click buttion to play audio
        var play_audio = document.getElementsByClassName("play_audio");
        for (var i = 0; i < play_audio.length; i++) {
            play_audio[i].onclick = play_audio_func;
        }

        // find the total number of questions
        var questions = document.getElementsByClassName("question_class");
        num_question = questions.length;

        // array of all the answers (label tag)
        var labels = document.getElementsByTagName("label");

        // set the event handler for each lable (answer)
        for (var i = 0; i < labels.length; i++) {
            labels[i].onclick = update_process;
        }
    };

    // define audio.stop
    function stop_audio(audio) {
        audio.pause();
        audio.currentTime = 0.0;
    }

    function play_audio_func() {
        var audio = document.getElementsByClassName("audio");
        var name = this.name;
        var split_value = name.split("_");
        var audio_curr = audio[split_value[1]];
        for (var i = 0; i < audio.length; i++) {
            // stop other audio
            if (i != split_value[1]) {
                stop_audio(audio[i]);
            }
        }
        // stop curr playing
        if (audio_curr.duration > 0.0) {
            stop_audio(audio_curr);
        }
        // first time play
        audio_curr.play();

    }

    function update_process() {
        if (this.disabled) {
            return;
        }
        // find the question's name tag
        var input = this.getElementsByTagName("input");
        name = input[0].getAttribute("name");

        var value = input[0].getAttribute("value");

        var split_value = value.split("_");
        var matched = split_value[0] == split_value[1];


        var found = list.indexOf(name);


        // if it didn't corrent before and it matched
        if (found == -1 && matched) {
            correct_num++;
            list.push(name);
            this.style.color = "blue";
            this.style.fontWeight = "bold";
            disable_buttons_all(name);
        } else if (found >= 0 && !matched) {  // if it was correct but now is wrong
            correct_num--;
            list.splice(found, 1);
        } else {
            return;
        }

        document.getElementById("barr").setAttribute("style", "width: " + (correct_num * 100 / num_question) + "%");

    }

    function disable_buttons_all(name) {
        var labels = document.getElementsByTagName("label");

        // set the event handler for each lable (answer)
        for (var i = 0; i < labels.length; i++) {
            //labels[i].onclick = update_process;
            var input = labels[i].getElementsByTagName("input");
            var name_now = input[0].getAttribute("name");
            console.log(name_now);
            if (name_now == name) {
                labels[i].className = "btn disabled";
                labels[i].disabled = true;
                input[0].disabled = true;

                console.log(input[0]);
            }
        }
    }

    function select_language() {
        var lanague = this.value;

    }
})();