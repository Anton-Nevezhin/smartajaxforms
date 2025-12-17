<!doctype html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <title>Список лидоFF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>

    <?php

    // получаем массив лидов из csv

    $order = 1; // 0 - в прямом, 1- в обратном порядке

    require_once 'smartajaxformsconfig.php';


    $filename = (isset($_GET['filename'])) ? $_GET['filename'].'.csv' : CSV_FILENAME ; 
    if(!file_exists($filename)) exit('Указанного csv файла нет ');
    $leads = [];
     if (($handle = fopen($filename, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 3000, ";")) !== FALSE) {
          $data[4]=(!isset($data[4])) ? 'Неизвестно':$data[4];
          $data[5]=(!isset($data[5])) ? '-': '-';
          $leads[] = $data;
        }
      }
    fclose($handle);

   if ($order==1)  krsort($leads); // сортируем если надо 

    ?>
      
    <table class="table table-sm table-bordered table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Дата</th>
      <th scope="col">Телефон</th>
      <th scope="col">Допполя</th>
      <th scope="col" style="max-width: 40vw;">Источник</th>
      
    </tr>
  </thead>
  <tbody>
      
    <?php

    $i=1;

    foreach ($leads AS $lead) {

            ?> 
    <tr>
      <th scope="row"><?=$i?></th>
      <td><?=$lead[0]?></td>
      <td><?=$lead[1]?></td>
      <td><?=$lead[2]?></td>
      <td style="max-width: 40vw;overflow:hidden;"><?=$lead[3]?></td>
      
          
    </tr>
    <?php
    
    $i++;
        
    }
    
?>
      </tbody>
</table>

      
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    -->
  </body>
</html>

