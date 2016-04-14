<?php

  class MyDate {

    const DAYS_IN_NON_LEAP_YEAR = 365;
    const MONTHS_IN_YEAR = 12;
    private $year;
    private $month;
    private $day;

    private static $daysInMonth = array(
      1 => 31,
      2 => 28,
      3 => 31,
      4 => 30,
      5 => 31,
      6 => 30,
      7 => 31,
      8 => 31,
      9 => 30,
      10 => 31,
      11 => 30,
      12 => 31,
    );

    public static function getDaysInMonth($m,$y){
      $days = self::$daysInMonth[$m];
      // leap year
      if($m == 2 && $y % 4 == 0){
        $days++;
      }
      return $days;
    }

    /**
     * @return mixed
     */
    public function getYear() {
      return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year) {
      $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getMonth() {
      return $this->month;
    }

    /**
     * @param mixed $month
     */
    public function setMonth($month) {
      $this->month = $month;
    }

    /**
     * @return mixed
     */
    public function getDay() {
      return $this->day;
    }

    public function getTotalDays(){
      $totalDays = $this->getTotalDaysFromYears();
      $totalDays += $this->getTotalDaysFromMonths();
      $totalDays += $this->getDay();
      return (int) $totalDays;
    }

    public function getTotalDaysFromYears(){
      $daysNoLeap = $this->getYear() * self::DAYS_IN_NON_LEAP_YEAR;
      $daysLeap = floor($this->getYear()/4);
      return $daysLeap + $daysNoLeap;
    }

    public function getTotalDaysFromMonths(){
      $days = 0;
      for($m = 1;$m<$this->getMonth();$m++){
        $days += self::getDaysInMonth($m,$this->getYear());
      }
      return $days;
    }

    /**
     * @param mixed $day
     */
    public function setDay($day) {
      $this->day = $day;
    }

    public function __construct($string){
      $parts = explode("/",$string);
      $this->setYear($parts[0]);
      $this->setMonth($parts[1]);
      $this->setDay($parts[2]);
    }

    public static function diff($start, $end) {
      $startDate = new MyDate($start);
      $endDate = new MyDate($end);

      $dateInterval = new MyDateInterval($startDate,$endDate);

      //die(print_r($dateInterval,1));

      // Sample object:
      return (object)array(
        'years' => $dateInterval->getYearsDiff(),
        'months' => $dateInterval->getMonthsDiff(),
        'days' => $dateInterval->getDaysDiff(),
        'total_days' => $dateInterval->getTotalDays(),
        'invert' => $dateInterval->getInvert()
      );
    }

  }
