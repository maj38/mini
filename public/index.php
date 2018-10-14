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
            $table .= "<html>


                   <thead>
                      <title>Bootstrap Example</title>
                       <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css\" integrity=\"sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm\" crossorigin=\"anonymous\">
                       <meta charset=\"utf-8\">
                       <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
                       <link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\"/>

                   </thead>
           <tbody>
                       <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css\" integrity=\"sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm\" crossorigin=\"anonymous\">
           <div class=\"container\">
           <link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\"/>




           <style>
           table{ table-layout: fixed;}
           table th, table td {overflow: hidden;}

           <style/>


           }

           </style>
                   <table class='table table-striped table-bordered'>";

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
        $table .= "</table>

<link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\"/>
       </div>
           <link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\"/>
       </tbody></html>";
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