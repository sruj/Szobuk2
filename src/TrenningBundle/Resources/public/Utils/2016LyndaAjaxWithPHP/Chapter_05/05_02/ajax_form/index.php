<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Asynchronous Form</title>
    <style>
      #result {
        display: none;
      }
    </style>
  </head>
  <body>

    <div id="measurements">
      <p>Enter measurements below to determine the total volume.</p>
      <form id="measurement-form" action="process_measurements.php" method="POST">
        Length: <input type="text" name="length" /><br />
        <br />
        Width: <input type="text" name="width" /><br />
        <br />
        Height: <input type="text" name="height" /><br />
        <br />
        <input id="html-submit" type="submit" value="Submit" />
        <input id="ajax-submit" type="button" value="Ajax Submit" />
      </form>
    </div>

    <div id="result">
      <p>The total volume is: <span id="volume"></span></p>
    </div>

    <script>

      var result_div = document.getElementById("result");
      var volume = document.getElementById("volume");

      function postResult(value) {
        volume.innerHTML = value;
        result_div.style.display = 'block';
      }

      function clearResult() {
        volume.innerHTML = '';
        result_div.style.display = 'none';
      }

      function calculateMeasurements() {
        clearResult();

        var form = document.getElementById("measurement-form");
        var action = form.getAttribute("action");

        // gather form data

        var xhr = new XMLHttpRequest();
        xhr.open('POST', action, true);
        // do not set content-type with FormData
        //xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function () {
          if(xhr.readyState == 4 && xhr.status == 200) {
            var result = xhr.responseText;
            console.log('Result: ' + result);
            postResult(result);
          }
        };
        xhr.send(form_data);
      }

      var button = document.getElementById("ajax-submit");
      button.addEventListener("click", calculateMeasurements);

    </script>

  </body>
</html>
