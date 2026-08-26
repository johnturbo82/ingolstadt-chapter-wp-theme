<?php
/* 
Template Name: Events Druckansicht
*/
date_default_timezone_set('Europe/Berlin');

$year = wp_date("Y");
if (isset($_GET['event_year'])) {
    $year = filter_input(INPUT_GET, "event_year", FILTER_SANITIZE_NUMBER_INT);
}

function get_events($year)
{
    define("ACCESS_TOKEN", "AIzaSyDqsTl72h4ZZyA8aU4wLXydf5jfuwHkrGU");
    define("CALENDAR_ID", "oll16805qsf7tfnpbac6oaen6s%40group.calendar.google.com");

    $year_to = $year;
    $year_links = "<a href='" . esc_url(add_query_arg('event_year', ($year - 1))) . "'>&laquo;&nbsp;" . ($year - 1) . "</a>&nbsp;|&nbsp;<b>" . $year . "</b>&nbsp;|&nbsp;";
    $year_links .= "<a href='" . esc_url(add_query_arg('event_year', ($year + 1))) . "'>" . ($year + 1) . "&nbsp;&raquo;</a>";
    $year_links .= "<h1>" . $year . "</h1>";
    $json_url = "https://www.googleapis.com/calendar/v3/calendars/" . CALENDAR_ID . "/events?key=" . ACCESS_TOKEN . "&timeMin=" . $year . "-01-01T00:00:00Z&timeMax=" . $year_to . "-12-31T23:59:59Z&orderBy=startTime&singleEvents=true";
    $json = file_get_contents($json_url);
    return json_decode($json);
}

function process_date($start, $end)
{
    if (isset($start->date)) {
        $output = "<td>" . date("d.m.", strtotime($start->date)) . " - " . date("d.m.", strtotime($end->date) - 1) . "</td>";
    } else {
        $output = "<td>" . date("d.m. H:i", strtotime($start->dateTime)) . " - " . date("H:i", strtotime($end->dateTime)) . "</td>";
    }
    return $output;
}

function get_weekday($start, $end)
{
    $weekdays = ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'];
    
    if (isset($start->date)) {
        $start_timestamp = strtotime($start->date);
        $end_timestamp = strtotime($end->date) - 86400; // -1 Tag für Ganztagesereignisse
    } else {
        $start_timestamp = strtotime($start->dateTime);
        $end_timestamp = strtotime($end->dateTime);
    }
    
    $start_weekday = $weekdays[date('w', $start_timestamp)];
    $end_weekday = $weekdays[date('w', $end_timestamp)];
    
    if (date('Y-m-d', $start_timestamp) == date('Y-m-d', $end_timestamp)) {
        return $start_weekday;
    } else {
        return $start_weekday . " - " . $end_weekday;
    }
}


$month = [
    "Januar",
    "Februar",
    "März",
    "April",
    "Mai",
    "Juni",
    "Juli",
    "August",
    "September",
    "Oktober",
    "November",
    "Dezember"
];
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jahresplan <?php echo $year; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h1>Jahresplan <?php echo $year; ?></h1>
<table>
<?php
$current_month = 0;
foreach (get_events($year)->items as $event) {
    if ($event->visibility == "private") {
        continue;
    }
    $obj_month = ($event->start->dateTime) ? (int)date("m", strtotime($event->start->dateTime)) : (int)date("m", strtotime($event->start->date));
    if ($current_month != $obj_month) {
        $current_month = $obj_month;
        echo "<tr><th colspan='3' style='background-color:#ccc;'>" . $month[$obj_month - 1] . " " . $year . "</th></tr>";
    }
    echo "<tr>";
    echo process_date($event->start, $event->end);
    echo "<td>" . get_weekday($event->start, $event->end) . "</td>";
    echo "<td><strong>" . esc_html($event->summary) . "</strong>" . (isset($event->location) ? "<br />" . esc_html(str_replace(", Deutschland", "", $event->location)) : "") . "</td>";
    echo "</tr>";
}
?>
</table>
</body>
</html>