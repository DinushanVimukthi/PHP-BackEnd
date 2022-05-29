<?php

use app\core\Application;
?>

Test D {{name}} {{Author}}

<button onclick="test()">Click Me</button>
<button onclick="test2()">Sign Out</button>
<button onclick="test3()">Sign In</button>
<div id="test"></div>
<script lang="js">
    function test() {
        const test = document.getElementById('test');
        const form=new FormData();
        form.append('email','test@test.com');
        form.append('password','TEst5@test.com');
        form.append('newPassword','Test5@test.com');
        const xhttp=new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log(xhttp.response);
                test.innerHTML = this.response;
            }
        };
        xhttp.open("GET", "http://localhost:8080/API/GET/CurrentUser", true);
        xhttp.send(form);
        xhttp.responseType = 'json';
    }
    function test2() {
        const test = document.getElementById('test');
        const form=new FormData();
        form.append('email','test@test.com');
        form.append('password','TEst5@test.com');
        form.append('newPassword','Test5@test.com');
        const xhttp=new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log(xhttp.response);
                test.innerHTML = this.response;
            }
        };
        xhttp.open("POST", "http://localhost:8080/API/POST/SignOut", true);
        xhttp.send(form);
        xhttp.responseType = 'json';
    }
    function test3() {
        const test = document.getElementById('test');
        const form=new FormData();
        form.append('email','test@test.com');
        form.append('password','TEst5@test.com');
        form.append('newPassword','Test5@test.com');
        const xhttp=new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log(xhttp.response);
                test.innerHTML = this.response;
            }
        };
        xhttp.open("POST", "http://localhost:8080/API/POST/SignInWithEP", true);
        xhttp.send(form);
        xhttp.responseType = 'json';
    }

</script>