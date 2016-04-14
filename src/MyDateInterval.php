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

  public function getMonthsDiff(){
    $yearsDiff = $this->getYearsDiff();
    $diff = 0;
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

  public function getDaysDiff($abs = true){
    $diff = $this->endDate->getDay() - $this->startDate->getDay();
    return $abs?abs($diff):$diff;
  }

  public function getTotalDays($abs = true){
    $diff = $this->endDate->getTotalDays() - $this->startDate->getTotalDays();
    return $abs?abs($diff):$diff;
  }






}
