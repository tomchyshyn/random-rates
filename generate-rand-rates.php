<?php

class randRatesGenerator
{
  protected $_rates = array();
  protected $_maxRate;
  protected $_ratesCount;
  protected $_ratesSum;

  function __construct($maxRate = 5)
  {
    $this->_maxRate = (int)$maxRate;
  }

  function generateRandRates($ratesCount, $ratesSum)
  {
    $this->_ratesCount = (int)$ratesCount;
    $this->_ratesSum   = (int)$ratesSum;

    if ($this->_ratesSum < 1 || $this->_ratesCount < 1) {
      return $this->_rates;
    }

    $avgRate = $this->_ratesSum / $this->_ratesCount;
    if ($avgRate > $this->_maxRate || $avgRate < 1) {
      throw new Exception("Average rate can't be greater than max rate or less than 1.");
    }

    $rate = $this->_ratesCount == 1 ? $this->_ratesSum : rand($this->_detectMinRate(), $this->_detectMaxRate());
    $this->_rates[] = $rate;
    return $this->generateRandRates(--$this->_ratesCount, $this->_ratesSum - $rate);
  }

  protected function _detectMinRate()
  {
    for ($minRate = 1; $minRate <= $this->_maxRate; ++$minRate) {
      if (($this->_ratesSum - $minRate) / ($this->_ratesCount - 1) < $this->_maxRate) {
        return $minRate;
      }
    }

    return $this->_maxRate;
  }

  protected function _detectMaxRate()
  {
    for ($maxRate = $this->_maxRate; $maxRate > 1; --$maxRate) {
      if (($this->_ratesSum - $maxRate) / ($this->_ratesCount - 1) > 1) {
        return $maxRate;
      }
    }

    return 1;
  }
}

//------------------------ USAGE ------------------------------

$generator = new randRatesGenerator();
print_r($generator->generateRandRates(5, 20));