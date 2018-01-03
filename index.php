<?php
header('Content-Type: text/html; charset=utf-8');
$cache_time = 3600;
$cache_file = 'cache.json';
if (file_exists('cache.json') && time() - $cache_time < filemtime($cache_file)) {
    $weather_moscow = file_get_contents($cache_file);
    $weather_moscow_array = json_decode($weather_moscow, true);
} else {
    $url = "http://api.openweathermap.org/data/2.5/weather?id=524901&lang=en&units=metric&APPID=fb8d7d00217c0936a1f4c63fd22c6b3c";
    $weather_moscow = file_get_contents($url);
    $weather_moscow_array = json_decode($weather_moscow, true);
    file_put_contents('cache.json', json_encode($weather_moscow_array, JSON_PRETTY_PRINT));
}
$weather_icon = $weather_moscow_array['weather']['0']['icon'];
$weather_temp = $weather_moscow_array['main']['temp'];
$weather_temp_min = $weather_moscow_array['main']['temp_min'];
$weather_temp_max = $weather_moscow_array['main']['temp_max'];
$weather_humidity = $weather_moscow_array['main']['humidity'];
$weather_sunrise = $weather_moscow_array['sys']['sunrise'];
$weather_sunset = $weather_moscow_array['sys']['sunset'];
$weather_pressure = $weather_moscow_array['main']['pressure'];
?>
<head>
    <title>Погода в Москве</title>
    <style type="text/css">
        table {
            border: solid 1px black;
            border-collapse: collapse;
        }
        td {
            border: solid 1px black;
            padding: 5px;
        }
    </style>
</head>
<body>
<h1>Москва</h1>
<p><?php echo date('d.m.o') ?></p>
<p><?php echo date('G:i') ?></p>
<img src="http://openweathermap.org/img/w/<?php echo $weather_icon;?>.png" alt="wicon">
<table>
    <tr>
        <td>Текущая температура</td>
        <td><?= $weather_temp ?>°C</td>
    </tr>
    <tr>
        <td>Минимальная температура</td>
        <td><?= $weather_temp_min ?>°C</td>
    </tr>
    <tr>
        <td>Максимальная температура</td>
        <td><?= $weather_temp_max ?>°C</td>
    </tr>
    <tr>
        <td>Влажность</td>
        <td><?= $weather_humidity ?> %</td>
    </tr>
    <tr>
        <td>Давление</td>
        <td><?= $weather_pressure?> гПа</td>
    </tr>
    <tr>
        <td>Восход</td>
        <td><?= date('G:i',$weather_sunrise)?> </td>
    </tr>
    <tr>
        <td>Закат</td>
        <td><?= date('G:i',$weather_sunset)?> </td>
    </tr>
</table>
</body>