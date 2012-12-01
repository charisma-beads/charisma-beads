<?php
function print_rr($data) {
    $html = "<pre>";
    $html .= print_r($data);
    $html .= "</pre>";
    return $html;
}

$testData = array(
'2012_06_25_1_26_backup.tar.gz',
'2012_07_06_5_27_backup.tar.gz',
'2012_06_16_6_24_vbBackup.tar.gz',
'2012_06_22_5_25_backup.tar.gz',
'2012_06_09_6_23_backup.tar.gz',
'2012_06_29_5_26_backup.tar.gz',
'2012_06_12_2_24_backup.tar.gz',
'2012_06_26_2_26_vbBackup.tar.gz',
'2012_06_28_4_26_vbBackup.tar.gz',
'2012_06_14_4_24_backup.tar.gz',
'2012_06_19_2_25_backup.tar.gz',
'2012_06_21_4_25_vbBackup.tar.gz',
'2012_06_23_6_25_vbBackup.tar.gz',
'2012_06_16_6_24_backup.tar.gz',
'2012_07_03_2_27_vbBackup.tar.gz',
'2012_07_05_4_27_vbBackup.tar.gz',
'2012_07_07_6_27_vbBackup.tar.gz',
'2012_07_03_2_27_backup.tar.gz',
'2012_07_05_4_27_backup.tar.gz',
'2012_06_21_4_25_backup.tar.gz',
'2012_06_26_2_26_backup.tar.gz',
'2012_07_07_6_27_backup.tar.gz',
'2012_06_30_6_26_vbBackup.tar.gz',
'2012_06_23_6_25_backup.tar.gz',
'2012_06_28_4_26_backup.tar.gz',
'2012_06_11_1_24_backup.tar.gz',
'2012_06_25_1_26_vbBackup.tar.gz',
'2012_06_29_5_26_vbBackup.tar.gz',
'2012_06_13_3_24_backup.tar.gz',
'2012_06_18_1_25_backup.tar.gz',
'2012_06_22_5_25_vbBackup.tar.gz',
'2012_06_15_5_24_backup.tar.gz',
'2012_06_30_6_26_backup.tar.gz',
'2012_07_02_1_27_vbBackup.tar.gz',
'2012_07_02_1_27_backup.tar.gz',
'2012_07_06_5_27_vbBackup.tar.gz',
'2012_06_19_2_25_vbBackup.tar.gz',


);

$dateMap = array(
    'd' => 'DOW',
    'm' => 'DOM',
    'Y' => 'DOY',
    'N' => 'DNOW',
    'W' => 'WNOY'
);

$date = array();

foreach ($dateMap as $key => $value) {
    $date[$value] = date($key);
}

$oldfiles = array();
$thisYear = array();
$prevYears = array();
print "<pre>";

foreach ($testData as $file) {

    //if ($file->isDot()) continue;

    $fn = $file;
    $fileBits = explode('_', $fn);
    $bkType = explode('.', $fileBits[5]);

    if ($fileBits[0] > $date['DOY'] - 6) {
        if ($fileBits[0] == $date['DOY']) {
            if ($fileBits[1] == $date['DOM']) {
                $thisYear[$fileBits[1]][$fileBits[4]][$bkType[0]][] = $fn;
            } else {
                $thisYear[$fileBits[1]][$bkType[0]][] = $fn;
            }
        } else {
            $prevYears[$fileBits[0]][$fileBits[1]][$bkType[0]][] = $fn;
        }
    } else {
        $oldfiles[] = $fn;
    }
}


print $date['DOM'] .' - ' . $date['DOW'] . ' - ' . $date['WNOY'] . '<br />';
// sort this years.
foreach ($thisYear as $month => $value) {
    foreach ($value as $week => $value) {
        // keep one per month.
        if ($month != $date['DOM']) {
            sort($value);
            array_pop($value);
            foreach ($value as $file) {
                $oldfiles[] = $file;
            }
        } else {
            // keep one per week
            if ($week != $date['WNOY']) {
                foreach ($value as $files) {
                    sort($files);
                    array_pop($files);
                    foreach ($files as $file) {
                        $oldfiles[] = $file;
                    }
                }
            }
        }
    }
}

// sort previous years. yet one per year.
foreach ($prevYears as $months) {
    ksort($months);
    $lastMonth = end($months);
    array_pop($months);
    foreach ($months as $key => $value) {
        foreach ($value as $types) {
            foreach ($types as $file) {
                $oldfiles[] = $file;
            }
        }
    }

    foreach ($lastMonth as $types) {
        sort($types);
        array_pop($types);
        foreach ($types as $file) {
            $oldfiles[] = $file;
        }
    }
}

print "</pre>";

print "<pre>";
print_r($oldfiles);
print "</pre>";

print "<pre>";
print_r(array_diff($testData, $oldfiles));
print "</pre>";
?>