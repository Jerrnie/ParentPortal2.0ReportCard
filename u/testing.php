<?php

                $dir    = 'RC/';
                $files2 = scandir($dir, 1);
                $file = $_GET['page'];

                $filename = 'filename.html';
            $without_extension = pathinfo($filename, PATHINFO_FILENAME);

            foreach ($files2 as $key => $value) {
            	echo pathinfo($value, PATHINFO_FILENAME)."<br>";
            	if (pathinfo($value, PATHINFO_FILENAME)=="99") {
            		echo $files2[$key];
            	}
            }



?>