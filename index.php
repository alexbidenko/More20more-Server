<?php
$boards = ['tqbr' => array('AFLT', 'ALRS', 'DSKY', 'GAZP'),
            'SMAL' => array('MOEX', 'ROSN', 'SBER', 'SBERP', 'SIBN', 'SNGS', 'SNGSP')];
            
$data_apr = array();
$data_apr_mid = array();
            
foreach($boards as $board => $indexes) {
    $year = date('Y');
    $month = date('m');
    $day = date('d');
    $finded = false;
    $today_data;
    while(!$finded) {
        $today_data = json_decode(
            file_get_contents(
                'http://iss.moex.com/iss/history/engines/stock/markets/shares/boards/'.$board.'/securities.json?date='.$year.'-'.$month.'-'.$day),
                true)['history']['data'];
        if(!$today_data) {
            $day--;
            if($day == 0) {
                $day = 31;
                $month--;
                if($month == 0) {
                    $month = 12;
                    $year--;
                }
            }
        } else {
            $finded = true;
        }
    }
    
    $day--;
    
    $finded = false;
    $yesterday_data;
    while(!$finded) {
        $yesterday_data = json_decode(
            file_get_contents(
                'http://iss.moex.com/iss/history/engines/stock/markets/shares/boards/'.$board.'/securities.json?date='.$year.'-'.$month.'-'.$day),
                true)['history']['data'];
        if(!$yesterday_data) {
            $day--;
            if($day == 0) {
                $day = 31;
                $month--;
                if($month == 0) {
                    $month = 12;
                    $year--;
                }
            }
        } else  {
            foreach($indexes as $index) {
                $today_mid;
                foreach ($today_data as $company) {
                    if($company[3] == $index) {
                        $today_mid = $company[10];
                    }
                }
                
                $yesterday_max;
                $yesterday_min;
                foreach ($yesterday_data as $company) {
                    if($company[3] == $index) {
                        $yesterday_max = $company[8];
                        $yesterday_min = $company[7];
                
                        if($today_mid > $yesterday_max) echo "<p style='background-color: green'>".$company[2]." покупать</p>";
                        else if($today_mid < $yesterday_min) echo "<p style='background-color: red'>".$company[2]." продавать</p>";
                        else echo "<p style='background-color: yellow'>".$company[2]." держать</p>";
                    }
                }
            }
    
            $finded = true;
        }
    }
    
    foreach($indexes as $index) {
        $data_apr[$index] = array();
        $data_apr_mid[$index] = array();
        foreach ($today_data as $company) {
            if($company[3] == $index) {
                array_push($data_apr[$index], $company[11]);
                array_push($data_apr[$index], $company[6]);
                
                array_push($data_apr_mid[$index], $company[10]);
            }
        }
        foreach ($yesterday_data as $company) {
            if($company[3] == $index) {
                array_push($data_apr[$index], $company[11]);
                array_push($data_apr[$index], $company[6]);
                
                array_push($data_apr_mid[$index], $company[10]);
            }
        }
    }
    
    for ($i = 0; $i < 1; $i++) {
        $day--;
        
        $finded = false;
        while(!$finded) {
            $index_data = json_decode(
                file_get_contents(
                    'http://iss.moex.com/iss/history/engines/stock/markets/shares/boards/'.$board.'/securities.json?date='.$year.'-'.$month.'-'.$day),
                    true)['history']['data'];
            if(!$index_data) {
                $day--;
                if($day == 0) {
                    $day = 31;
                    $month--;
                    if($month == 0) {
                        $month = 12;
                        $year--;
                    }
                }
            } else  {
                foreach($indexes as $index) {
                    foreach ($index_data as $company) {
                        
                        if($company[3] == $index) {
                            array_push($data_apr[$index], $company[11]);
                            array_push($data_apr[$index], $company[6]);
                            
                            array_push($data_apr_mid[$index], $company[10]);
                        }
                    }
                }
                
                $finded = true;
            }
        }
    }
}

$boards = ['CETS' => array('EURRUB_TOD', 'EURRUB_TOM', 'USDRUB_TOD', 'USDRUB_TOM', 'EURUSD_TOD', 'EURUSD_TOM')];
foreach($boards as $board => $indexes) {
    $year = date('Y');
    $month = date('m');
    $day = date('d');
    $finded = false;
    $today_data;
    while(!$finded) {
        $today_data = json_decode(
            file_get_contents(
                'http://iss.moex.com/iss/history/engines/currency/markets/selt/boards/'.$board.'/securities.json?date='.$year.'-'.$month.'-'.$day),
                true)['history']['data'];
        if(!$today_data) {
            $day--;
            if($day == 0) {
                $day = 31;
                $month--;
                if($month == 0) {
                    $month = 12;
                    $year--;
                }
            }
        } else {
            $finded = true;
        }
    }
    
    $day--;
    
    $finded = false;
    $yesterday_data;
    while(!$finded) {
        $yesterday_data = json_decode(
            file_get_contents(
                'http://iss.moex.com/iss/history/engines/currency/markets/selt/boards/'.$board.'/securities.json?date='.$year.'-'.$month.'-'.$day),
                true)['history']['data'];
        if(!$yesterday_data) {
            $day--;
            if($day == 0) {
                $day = 31;
                $month--;
                if($month == 0) {
                    $month = 12;
                    $year--;
                }
            }
        } else  {
            $finded = true;
        }
    }
    
    foreach($indexes as $index) {
        $today_mid;
        foreach ($today_data as $company) {
            if($company[2] == $index) {
                $today_mid = $company[10];
            }
        }
        
        $yesterday_max;
        $yesterday_min;
        foreach ($yesterday_data as $company) {
            if($company[2] == $index) {
                $yesterday_max = $company[6];
                $yesterday_min = $company[5];
        
                if($today_mid > $yesterday_max) echo "<p style='background-color: green'>".$company[2]." покупать</p>";
                else if($today_mid < $yesterday_min) echo "<p style='background-color: red'>".$company[2]." продавать</p>";
                else echo "<p style='background-color: yellow'>".$company[2]." держать</p>";
            }
        }
    }
    
    foreach($indexes as $index) {
        $data_apr[$index] = array();
        $data_apr_mid[$index] = array();
        foreach ($today_data as $company) {
            if($company[2] == $index) {
                array_push($data_apr[$index], $company[7]);
                array_push($data_apr[$index], $company[4]);
                
                array_push($data_apr_mid[$index], $company[10]);
            }
        }
        foreach ($yesterday_data as $company) {
            if($company[2] == $index) {
                array_push($data_apr[$index], $company[7]);
                array_push($data_apr[$index], $company[4]);
                
                array_push($data_apr_mid[$index], $company[10]);
            }
        }
    }
    
    for ($i = 0; $i < 1; $i++) {
        $day--;
        
        $finded = false;
        while(!$finded) {
            $index_data = json_decode(
                file_get_contents(
                    'http://iss.moex.com/iss/history/engines/currency/markets/selt/boards/'.$board.'/securities.json?date='.$year.'-'.$month.'-'.$day),
                    true)['history']['data'];
            if(!$index_data) {
                $day--;
                if($day == 0) {
                    $day = 31;
                    $month--;
                    if($month == 0) {
                        $month = 12;
                        $year--;
                    }
                }
            } else  {
                foreach($indexes as $index) {
                    foreach ($index_data as $company) {
                        
                        if($company[2] == $index) {
                            array_push($data_apr[$index], $company[7]);
                            array_push($data_apr[$index], $company[4]);
                            
                            array_push($data_apr_mid[$index], $company[10]);
                        }
                    }
                }
                
                $finded = true;
            }
        }
    }
}

function approximat($X, $Y, $x)
{
// вычисление ближайшего большего и его индекса
    $n = count($Y);
    $max = $X[0];
    $indexMax = 0;  // индекс
    for ($i = 0; $i < $n; $i++) {
        if ($X[$i] <= $max && $x <= $X[$i]) {
            $max = $X[$i];
            $indexMax = $i;
        }
    }

// вычисление ближайшего меньшего и его индекса

    $min = $X[$n];
    $indexMin = 0;
    for ($i = 0; $i < $n; $i++) {
        if ($X[$i] >= $min && $x >= $X[$i]) {
            $min = $X[$i];
            $indexMin = $i;
        };
    }
    // вычисление нужного Y
        $Y = (($max - $x) / ($max - $min)) * $Y[$indexMin] + (($x - $min) / ($max - $min)) * $Y[$indexMax];
    return $Y;
}

echo "<p>По открытию - закрытию</p>";

foreach($data_apr as $paper => $data) {
    $X = array();
    $Y= array();
    foreach ($data as $x => $y) {
        array_push($X, $x);
        array_push($Y, $y);
    }
    $Y = array_reverse($Y);
    $fut[0] = round(approximat($X, $Y, count($X), 2));
    $fut[1] = round(approximat($X, $Y, count($X) + 1), 2);
    $fut[2] = round(approximat($X, $Y, count($X) + 2), 2);
    $fut[3] = round(approximat($X, $Y, count($X) + 3), 2);
    $fut[4] = round(approximat($X, $Y, count($X) + 4), 2);
    $fut[5] = round(approximat($X, $Y, count($X) + 5), 2);
    
    echo "<p>".$paper.": n: ".$Y[count($Y) - 1].", m: ".$fut[0].", e: ".$fut[1].", f1: ".$fut[2].", f2: ".$fut[3].", f3: ".$fut[4].", f4: ".$fut[5]."; ";
    if ($fut[1] > $Y[count($Y) - 1]) echo "<span style='color: green;'>Покупать</span> - ";
    else echo "<span style='color: red;'>Продавать</span> - ";
    if ($fut[5] > $Y[count($Y) - 1]) echo "<span style='color: green;'>Покупать</span>";
    else echo "<span style='color: red;'>Продавать</span>";
    echo "</p>";
}

echo "<p>По среднедневному значению</p>";

foreach($data_apr_mid as $paper => $data) {
    $X = array();
    $Y= array();
    foreach ($data as $x => $y) {
        array_push($X, $x);
        array_push($Y, $y);
    }
    $Y = array_reverse($Y);
    $fut[0] = round(approximat($X, $Y, count($X), 2));
    $fut[1] = round(approximat($X, $Y, count($X) + 1), 2);
    $fut[2] = round(approximat($X, $Y, count($X) + 2), 2);
    $fut[3] = round(approximat($X, $Y, count($X) + 3), 2);
    $fut[4] = round(approximat($X, $Y, count($X) + 4), 2);
    $fut[5] = round(approximat($X, $Y, count($X) + 5), 2);
    
    echo "<p>".$paper.": n: ".$Y[count($Y) - 1].", m: ".$fut[0].", e: ".$fut[1].", f1: ".$fut[2].", f2: ".$fut[3].", f3: ".$fut[4].", f4: ".$fut[5]."; ";
    if ($fut[1] > $Y[count($Y) - 1]) echo "<span style='color: green;'>Покупать</span> - ";
    else echo "<span style='color: red;'>Продавать</span> - ";
    if ($fut[5] > $Y[count($Y) - 1]) echo "<span style='color: green;'>Покупать</span>";
    else echo "<span style='color: red;'>Продавать</span>";
    echo "</p>";
}
?>