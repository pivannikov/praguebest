<?php


class Person 
{
    private int $id;
    private string $first_name;
    private string $last_name;
    private string $gender;
    private DateTimeImmutable $birth_date;

    public function __construct(
        int $id, 
        string $first_name, 
        string $last_name, 
        string $gender, 
        string $birth_date,
    ) {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->gender = $gender;
        $this->birth_date = new DateTimeImmutable($birth_date);
    }

    public function getId(): int {
        return $this->id;
    }
    public function getFirstName(): string {
        return $this->first_name;
    }
    public function getLastName(): string {
        return $this->last_name;
    }
    public function getGender(): string {
        return $this->gender;
    }
    public function getBirthDate(): DateTimeImmutable {
        return $this->birth_date;
    }


    public function lifeExpectancyCalculate() : int {

        $current_date = new DateTime();

        $life_expectancy = $current_date->diff($this->birth_date)->format("%a");

        return $life_expectancy;

    }

}