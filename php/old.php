




<!--
<h2>Aktuelle Zeit erhalten</h2>

<table>
    <tr>
        <form method="post">
            <input type="submit" name="button1" class="button" value="Get Current Time" />
        </form>
        <?php


        if (array_key_exists('button1', $_POST)) {
            get();
        }
        function get()
        {
            $body = '{
                "path":"System:Time"
            }';

            $return_get = dp_get(HOST, PORT, "", PROTOCOL, ENDPOINT, $body);

            // Check for Error
            if ($return_get["get"][0]["code"] != "ok") {
                echo $return_get["get"][0]["message"] . "<br>";
            }

            foreach ($return_get["get"] as $value) {
                echo $value["value"] . "<br>";
            }
        }
        ?>
    </tr>
</table>

<hr>

<h2>Neues Datenelement erstellen</h2>
    -->
<!-- A form with input field and submit button -->
<!--
<form method="post">
    Path: <input type="text" name="path">
    Value: <input type="text" name="value">
    <input type="submit" value="Datenelement erstellen" name="button2">
</form>

<?php
if (array_key_exists('button2', $_POST)) {

    // Get input field value
    $path = htmlspecialchars($_REQUEST['path']);
    $value = htmlspecialchars($_REQUEST['value']);

    if (empty($path)) {

        echo "Path is empty";
    } else {

        $body = '{"path":"' . $path . '", "value":"' . $value . '", "create": true}';
        $return_set =  dp_set(HOST, PORT, PROTOCOL, ENDPOINT, $body);

        if ($return_set["set"][0]["code"] != "ok") {
            echo $return_set["get"][0]["message"];
        } else {
            echo $path . " wurde erstellt.";
        }
    }
}
?>

<hr>

<h2>Daten auslesen mit Query</h2>
<p>Gebe den RegEx vom Query Path ein. Der Query sieht dann folgendermassen aus:</p>
<p>{"path":"","query":{"regExPath":" $Input "}}"</p>
<form method="post">
    Query: <input type="text" name="query" value="^(Test).*$">
    <input type="submit" value="Daten auslesen" name="button3">
</form>

<?php

$query = htmlspecialchars($_REQUEST['query']);
$body = '{"path":"","query":{"regExPath":"' . $query . '"}}';

$return_get = dp_get(HOST, PORT, "", PROTOCOL, ENDPOINT, $body);

foreach ($return_get["get"] as $value) {
    echo implode(" ", $value);
    echo "<br>";
}

?>



<hr>
<?php

$body = '{"path": "Test99:NewValue7", "value": "abc", "create": true}';

$return_set =  dp_set(HOST, PORT, PROTOCOL, ENDPOINT, $body);

// Check for Error
if (isset($return_set["set"][0]["code"])) {
    echo  $return_set["set"][0]["code"] . "\n";
} else {
    echo $return_set["get"][0]["message"] . "\n";
}

?>





<br>


<?php

$body = '{"path":"Test:NewValue7","newPath":"Test:VeryNewValue3"}';

$return_rename =  dp_rename(HOST, PORT, PROTOCOL, ENDPOINT, $body);

// Check for Error
if (isset($return_rename["rename"][0]["code"])) {
    $code = $return_rename["rename"][0]["code"];
    if ($code != 'ok') {
        echo $return_rename["rename"][0]["message"];
    } else {
        echo 'Current Time';
    }
} else {
    echo $return_rename["get"][0]["message"] . "\n";
}




?>


<br>


<?php

$body = '{"path":"Test99:NewValue77"}';

$return_delete =  dp_delete(HOST, PORT, PROTOCOL, ENDPOINT, $body);

// Check for Error
if (isset($return_delete["delete"][0]["code"])) {
    $code = $return_delete["delete"][0]["code"];
    if ($code != 'ok') {
        echo $return_delete["delete"][0]["message"];
    } else {
        echo $code;
    }
} else {
    echo $return_delete["get"][0]["message"] . "\n";
}




?>
-->