<?php
/**
* Clieop DEBTOR sample
*
* $Revision$
*/
include_once("Payment_Clieop/clieop.php");

header("Content-type: text/plain");

$clieopFile = new ClieopPayment();

//set clieop properties
$clieopFile->setTransactionType(CLIEOP_TRANSACTIE_INCASSO);
$clieopFile->setPrincipalAccountNumber("123456789");
$clieopFile->setPrincipalName("PEAR CLIEOP CLASSES");
$clieopFile->setFixedDesciption("PHP: Scripting the web");
$clieopFile->setSenderIndentification("PEAR");
$clieopFile->Test(true);

//create debtor
$debtor = new TransactionPayment(CLIEOP_TRANSACTIE_INCASSO);
$debtor->setAccountNumberSource("192837346");
$debtor->setAccountNumberDest("123456789");
$debtor->setAmount(12995);
$debtor->setName("Dave Mertens");
$debtor->setCity("Rotterdam");
$debtor->setDescription("Ordernumber: 8042");
$debtor->setDescription("Customernumber: 17863");

//assign debtor record to clieop
$clieopFile->addPayment($debtor);

//Create clieop file
echo $clieopFile->writeClieop();

?>