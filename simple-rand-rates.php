<?php

function generateRandRates($ratesCount, $ratesSum, $maxRate = 5, &$rates = array())
{
  if ($ratesSum < 1 || $ratesCount < 1) {
    return $rates;
  }

  $avgRate = $ratesSum / $ratesCount;
  if ($avgRate > $maxRate || $avgRate < 1) {
    //throw new Exception("Average rate can't be greater than max rate or less than 1.");
    return false;
  }

  $rate = rand(floor($avgRate), ceil($avgRate));
  $rates[] = $rate;
  return generateRandRates(--$ratesCount, $ratesSum - $rate, $maxRate, $rates);
}

//------------------------ USAGE ------------------------------

print_r(generateRandRates(8, 27));