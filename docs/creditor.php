<?php
/**
 * Copyright (c) 2010, The PHP Group
 *
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * - Redistributions of source code must retain the above copyright
 *   notice, this list of conditions and the following disclaimer.
 * - Redistributions in binary form must reproduce the above copyright
 *   notice, this list of conditions and the following disclaimer in 
 *   the documentation and/or other materials provided with the distribution.
 * - Neither the name of The PHP Group nor the names of its contributors 
 *   may be used to endorse or promote products derived from this
 *   software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS 
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE 
 * COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF
 * USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND 
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, 
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT
 * OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF 
 * SUCH DAMAGE.
 *
 * @author Dave Mertens <dmertens@zyprexia.com>
 * @version $Id$
 * @package Payment_Clieop
 */

/**
* Clieop CREDITOR sample
*
* $Revision$
*/
include_once("Payment/Clieop.php");
include_once("Payment/Clieop/Transaction.php");

header("Content-type: text/plain");

$clieopFile = new Payment_Clieop();

//set clieop properties
$clieopFile->setTransactionType(CLIEOP_TRANSACTIE_BETALING);	// debtor transactions
$clieopFile->setPrincipalAccountNumber("123456789");			// principal bank account number
$clieopFile->setPrincipalName("PEAR CLIEOP CLASSES");			// Name of owner of principal account number
$clieopFile->setFixedDescription("PHP: Scripting the web");		// description for all transactions
$clieopFile->setSenderIdentification("PEAR");					// Free identification
$clieopFile->setTest(true);										// Test clieop


//create creditor
$creditor = new Payment_Clieop_Transaction(CLIEOP_TRANSACTIE_BETALING);
$creditor->setAccountNumberSource("192837346");					// my bank account number
$creditor->setAccountNumberDest("123456789");					// principal bank account number
$creditor->setAmount(6900);										// amount in Eurocents (EUR 69.00)
$creditor->setName("Dave Mertens");								// Name of creditor (holder of source account)
$creditor->setCity("Rotterdam");								// City of creditor
$creditor->setDescription("Like we promised, your money");				// Just some info

//assign creditor record to clieop
$result = $clieopFile->addPayment($creditor);
if (PEAR::isError($result))
{
	echo "Error from addPayment: ".$result->getMessage()."\n";
}

//Create clieop file
$result = $clieopFile->writeClieop();
if (PEAR::isError($result))
{
	echo "Error from writeClieop: ".$result->getMessage()."\n";
}

echo $result;
