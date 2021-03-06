<?php

class MyDateInterval {

  /* @var $startDate MyDate */
  private $startDate;
  /* @var $endDate MyDate */
  private $endDate;
  private $invert;

  private function setInvert(){
    $this->invert = $this->startDate->getTotalDays() > $this->endDate->getTotalDays();
  }

  /**
   * @return MyDate
   */
  public function getStartDate() {
    return $this->startDate;
  }

  /**
   * @param MyDate $startDate
   */
  public function setStartDate(MyDate $startDate) {
    $this->startDate = $startDate;
  }

  /**
   * @return MyDate
   */
  public function getEndDate() {
    return $this->endDate;
  }

  /**
   * @param MyDate $endDate
   */
  public function setEndDate(MyDate $endDate) {
    $this->endDate = $endDate;
  }

  /**
   * @return mixed
   */
  public function getInvert() {
    return $this->invert;
  }

  /**
   * @param MyDate $startDate
   * @param MyDate $endDate
   */
  public function __construct(MyDate $startDate, MyDate $endDate){
    $this->setStartDate($startDate);
    $this->setEndDate($endDate);
    $this->setInvert();
  }

  /**
   * @param $name
   * @return int|mixed|null|number
   */
  public function __get($name) {
    $ret = null;
    switch($name){
      CASE "years":
        $ret = $this->getYearsDiff();
        break;
      CASE "months":
        $ret = $this->getMonthsDiff();
        break;
      CASE "days":
        $ret = $this->getDaysDiff();
        break;
      CASE "total_days":
        $ret = $this->getTotalDays();
        break;
      CASE "invert":
        $ret = $this->getInvert();
        break;
    }
    return $ret;
  }

  /**
   * @return int
   */
  public function getYearsDiff(){
    $yearDiff = abs($this->endDate->getYear() - $this->startDate->getYear());
    $daysDiff = $this->getTotalDays(true);
    $leapRemainderStart = $this->getStartDate()->getYear() % 4;
    $leapDays = 0;
    if($leapRemainderStart == 0){
      $leapDays++;
    }
    $leapDays += floor($leapRemainderStart + $yearDiff)/4;
    $daysDiff += $leapDays;
    $diff = floor($daysDiff/MyDAte::DAYS_IN_NON_LEAP_YEAR);

    return (int) $diff;
  }

  /**
   * @return int|number
   */
  public function getMonthsDiff(){
    $yearsDiff = $this->getYearsDiff();
    if($yearsDiff < abs($this->endDate->getYear() - $this->startDate->getYear())){
      if(!$this->invert){
        $diff = MyDate::MONTHS_IN_YEAR - $this->startDate->getMonth() + $this->endDate->getMonth();
        if($this->getDaysDiff(false) < 0){
          $diff--;
        }
      } else {
        $diff = MyDate::MONTHS_IN_YEAR - $this->endDate->getMonth() + $this->startDate->getMonth();
        if($this->getDaysDiff(false) > 0){
          $diff--;
        }
      }

    } else {
      $diff = abs($this->endDate->getMonth() - $this->startDate->getMonth());
    }

    return $diff;

  }

  /**
   * @param bool|true $abs
   * @return mixed|number
   */
  public function getDaysDiff($abs = true){
    $diff = $this->endDate->getDay() - $this->startDate->getDay();
    return $abs?abs($diff):$diff;
  }

  /**
   * @param bool|true $abs
   * @return int|number
   */
  public function getTotalDays($abs = true){
    $diff = $this->endDate->getTotalDays() - $this->startDate->getTotalDays();
    return $abs?abs($diff):$diff;
  }






}
