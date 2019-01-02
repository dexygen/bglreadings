<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>George Jempty's BGL's</title>
</head>

<body>
    <div style="display:none">
        <textarea rows="16" cols="64" id="entered-md"></textarea>
        <br />
        <input type="submit" value="Update BG Levels">
        <hr />
    </div>
    <div id="parsed-md"></div>
    <script src="micromarkdown.min.js"></script>
    <script>
        ajax('GET', "./bgl.php", ajaxSuccess, ajaxFailure);

        function ajax(method, url, success, failure) {
            var xhr = new XMLHttpRequest();
            xhr.open(method, url, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status >= 200 && xhr.status <= 299) {
                        success(xhr.response);
                    } else {
                        failure(xhr.response);
                    }
                }
            }
            xhr.send();
            return xhr;
        }

        function ajaxSuccess(xhrResponse) {
            var queryStr = window.location.search;
            var enteredMd = document.getElementById("entered-md");
            var html = micromarkdown.parse(xhrResponse);
            var parsedMd = document.getElementById("parsed-md");
            var baselineColor = "#d9edf7";
            var rows;

            if (queryStr === '?edit_md') {
                enteredMd.parentNode.style.display = 'block';
                enteredMd.value = xhrResponse;
            }

            parsedMd.innerHTML = html;
            rows = parsedMd.getElementsByTagName('TR');

            var mdLines = xhrResponse.split("\n");
            var bgLevelLines = [mdLines[1]].concat(mdLines.slice(3));
            var fastingBgLevel;
            var bgValueAfter2Hours;
            var fastingBgLevelDiff;
            var fastingBgLevelDiffSeverity;
            var bgValueAfter2HoursDiff;
            var bgValueAfter2HoursDiffSeverity;
            var severityColors = [baselineColor, '#FFCCBC', '#FFAB91', '#FF8A65', '#FF7043'];

            [].forEach.call(rows, function(row, index) {
                if (index === 0) {
                    rows[0].cells[3].style.backgroundColor = baselineColor;
                } else {
                    fastingBgLevel = Number(rows[index].cells[3].innerText);
                    bgLevelAfter2Hours = Number(rows[index].cells[6].innerText);
                    fastingBgLevelDiff = Number(rows[index - 1].cells[3].innerText) - fastingBgLevel;
                    fastingBgLevelDiffSeverity = -Math.ceil((fastingBgLevelDiff - 5) / 10);

                    rows[index].cells[3].style.backgroundColor = severityColors[fastingBgLevelDiffSeverity];

                    if (bgValueAfter2Hours !== 0) {
                        bgLevelAfter2HoursDiff = fastingBgLevel - bgLevelAfter2Hours;
                        bgValueAfter2HoursDiffSeverity = -Math.ceil((bgLevelAfter2HoursDiff - 5) / 10);
                        rows[index].cells[6].style.backgroundColor = severityColors[bgValueAfter2HoursDiffSeverity];
                    }
                }
            });
        }

        function ajaxFailure(xhrResponse) {
            alert(xhrResponse);
        }
    </script>
</body>

</html>