<?php
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'insert':
                insert();
                break;
            case 'select':
                select();
                break;
        }
    }

    function init(){
        $rValue = "";
        $query = ("SELECT sidebarposts FROM table;");
        $result = mysql_query($query);
        if ($row = mysql_fetch_array($result)){
            $rValue = $row['sidebarposts'];
        }
    return $rValue;
    }
?>