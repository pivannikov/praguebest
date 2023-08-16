<?php


class Group
{
    private static $instance = null;
    private static $persons_storage = [];
    private static $source_file;

    protected function __construct()
    {}

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize.");
    }

    public static function getInstance(): Group {

        if (self::$instance === null) {
        self::$instance = new self();
        }

        return self::$instance;
    }

    public function setSourceFile(string $file_name): void {
        self::$source_file = $file_name;
    }
    public function addPerson(Person $person, int $id): void {
        self::$persons_storage[$id] = $person;
    }
    public function getPersonById(int $id): Person {
        return self::$persons_storage[$id];
    }

    public function deletePersonById($id): void {
        unset(self::$persons_storage[$id]);
    }

    public function getPersonsStorage(): array {
        return self::$persons_storage;
    }

    public function getGenderPercent(string $gender) {
        if ( $gender !== 'mu¾' && $gender !== '¾ena' ) {
            echo "Not a gender string";
            exit;
        }
        $male = 0;
        $female = 0;
        foreach(self::$persons_storage as $item) {
            if ($item->getGender() == 'mu¾' ) {
                $male++;
            } else $female++;
        }

        if ( $gender == 'mu¾' && $male == 0 ) {

            return "There are no men on the list";

        } else if ( $gender == '¾ena' && $female == 0) {

            return "There are no women on the list";

        } else {
            $final_percent = [
                'mu¾' => $male / (($male + $female) / 100),
                '¾ena' => $female / (($male + $female) / 100),
            ];
            return round($final_percent[$gender], 2);
        }
       
    }

    public function getFileContent() {

        $handle = @fopen(self::$source_file, "r");
        while (($line = fgets($handle, 4096)) !== false) {
            yield $line;
        }
        fclose($handle);
    }

    public function fillPersonsStorage() {

        // $res = new SplFixedArray(100);

        $iterator = self::$instance->getFileContent(self::$source_file);
        $buffer = "";
        $i = 0;
        $person_id = 1;
        foreach ($iterator as $iteration) {
            // echo json_encode($iteration) . '<br>';

            preg_match("#^\n#", $iteration, $matches);

            if (count($matches)) {

                $person_info = explode("\n", $buffer);
                $person_full_name = $person_info[0];      
                $person_addition_info = $person_info[1];      

                $last_name = preg_replace('#.+\s+(\w+)$#', '$1', $person_full_name);
                $first_name = trim( preg_replace('#'.$last_name.'#', '', $person_full_name ) );
                
                $birth_date = preg_replace('#([a-zA-Z?-¾+])#', '${2}', $person_addition_info);
                $gender = preg_replace('#'.$birth_date.'#', '', $person_addition_info);

                $current_person = new Person($person_id, $first_name, $last_name, $gender, $birth_date);
                self::addPerson($current_person, $person_id);

                $person_id++;
                
                $buffer = '';

            } else {

                $buffer .= $iteration;
            }
            $i++;
        }
    }

}








