<?php


use tests\codeception\_pages\Reservapage;

$I = new FunctionalTester($scenario);
$I->wantTo('ensure that about works');
Reservapage::openBy($I);
$I->see('Reserva', 'h1');

$I->amGoingTo('submit reserva form with no data');
$Reservapage->submit([]);
