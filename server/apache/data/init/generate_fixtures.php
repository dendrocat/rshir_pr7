<?php

require_once "/server/vendor/autoload.php";

function next_data($faker, $countries) {
    return "(" .
    "'" . addslashes($faker->city) . "'," .
    "'" . $faker->postcode . "'," .
    $faker->numberBetween(50000, 10000000) . "," .
    "'" . addslashes($faker->name) . "'," .
    "'" . addslashes($faker->randomElement($countries)) . "')";
    // return array(
    //     "name" => $faker->city,
    //     "postcode" => $faker->postcode,
    //     "number" =>  $faker->numberBetween(50000, 10000000),
    //     "mayor" => $faker->name,
    //     "country" => $faker->country
    // );
}

function generate_countries($faker, $cnt) {
    $countries = [];
    while (count($countries) < $cnt) {
        $n_country = $faker->country;
        if (!in_array($n_country, $countries))
            $countries[] = $n_country;
    }
    return $countries;
}

function generate_fixtures() {
    $faker = Faker\Factory::create("ru_RU");

    $fixtures = "";

    $num_countries = 20;
    $countries = generate_countries($faker, $num_countries);

    $num = 100;
    for ($i = 0; $i < $num - 1; ++$i)
        $fixtures .= next_data($faker, $countries) . ",";

    $fixtures .= next_data($faker, $countries);



    $q = "INSERT INTO cities (name, postcode, number, mayor, country) VALUES " . $fixtures;

    while (True) {
        try {
            DatabaseSQL::query($q);
            break;
        }
        catch (Exception $e) {
            echo "MySQL Error: " . $e->getMessage() . "\n";
            sleep(2);
        }
    }
}

?>