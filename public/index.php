<?php
/**
 * Created by PhpStorm.
 * User: mohamad
 * Date: 10/6/18
 * Time: 11:33 PM
 */
main::start("example.csv");

class main  {

    static public function start($filename) {

        $records = csv::getRecords($filename);
        $table = html::generateTable($records);
       echo $table;

    }
}

class html {

    public static function generateTable($records) {

        $count = 0;
        $table = "";

        foreach ($records as $record) {
            $table .= "<html><head></head><body><table class='table table-striped'>";


            if ($count == 0) {

                $array = $record->returnArray();
                $fields = array_keys($array);
                $table .= "<tr>";
                //echo "<tr>;
                foreach ($fields as $field) {
                    $table .= "<th>" . $field . "</th>";
                    $count = 1;

                }
                $table .= "</tr>";
            }
            $array = $record->returnArray();
            $values = array_values($array);
            $table .= "<tr>";
            foreach ($values as $value) {
                $table .= "<td>" . $value . "</td>";
            }
            $table .= "</tr>";
        }

            $table .= "</table></body></html>";
        return $table;
        }
    }


class csv {


    static public function getRecords($filename) {

        $file = fopen($filename,"r");

        $fieldNames = array();

        $count = 0;


        while(! feof($file))
        {

            $record = fgetcsv($file);
            if($count == 0) {
                $fieldNames = $record;
            } else {
                $records[] = recordFactory::create($fieldNames, $record);
            }
            $count++;
        }

        fclose($file);
        return $records;
    }

}

class record {

    public function __construct(Array $fieldNames = null, $values = null )
    {
        $record = array_combine($fieldNames, $values);

        foreach ($record as $property => $value) {
            $this->createProperty($property, $value);
        }

    }

    public function returnArray() {
        $array = (array) $this;

        return $array;
    }

    public function createProperty($name = 'first', $value = 'keith') {

        $this->{$name} = $value;

    }
}

class recordFactory {

    public static function create(Array $fieldNames = null, Array $values = null) {
        $record = new record($fieldNames, $values);

        return $record;

    }
}

