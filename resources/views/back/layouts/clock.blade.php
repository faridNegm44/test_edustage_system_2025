<script>
    requestAnimFrame = (function(){
        return  requestAnimationFrame ||
            function( callback ){
                window.setTimeout(callback, 1000 / 60);
            };
    })();


    (function clock(){
        let hour = document.getElementById("hour"),
            min = document.getElementById("min"),
            sec = document.getElementById("sec");
        //set up a loop
        (function loop(){
            requestAnimFrame(loop);
            draw();
        })();
        //position the hands
        function draw(){
            let now = new Date(),//now
                then = new Date(now.getFullYear(),now.getMonth(),now.getDate(),0,0,0),//midnight
                diffInMil = (now.getTime() - then.getTime()),// difference in milliseconds
                h = (diffInMil/(1000*60*60)),//hours
                m = (h*60),//minutes
                s = (m*60);//seconds
            //rotate the hands accordingly
            sec.style.webkitTransform = "rotate(" + (s * 6) + "deg)";
            hour.style.webkitTransform = "rotate(" + (h * 30 + (h / 2)) + "deg)";
            min.style.webkitTransform = "rotate(" + (m * 6) + "deg)";
        }
    })();

    function printDateTime() {
    let now = new Date();
    let date = now.getDate();
    let month = now.getMonth() + 1;
    let year = now.getFullYear();
    let hour = now.getHours();
    let minute = now.getMinutes();
    let second = now.getSeconds();
    let amPm = hour > 12 ? "PM" : "AM";

    const weekday = ["الأحد","الإثنين","الثلاثاء","الأربعاء","الخميس","الجمعة","السبت"];
    let day = weekday[now.getDay()];

        $('#date').html(day + ' <br> ' + year + "-" + month + "-" + date + ' <br> ' + amPm + " " + (hour > 12 ? hour -= 12 : hour) + ":" + minute + ":" + second);
    }

    printDateTime();
    setInterval(printDateTime, 1000);
</script>