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


//Define some constants for easy programming  ;-)

/**
* Constant for debtor transactions
* @const CLIEOP_TRANSACTIE_INCASSO Clieop transaction code for debtor transactions
*/
define( "CLIEOP_TRANSACTIE_INCASSO", "10" );    //Incasso transaction type (debtor)

/**
* Constant for creditor transactions
* @const CLIEOP_TRANSACTIE_BETALING Clieop transaction code for creditor transactions
*/
define( "CLIEOP_TRANSACTIE_BETALING", "00" );     //betaling transaction type (creditor)

/**
* Data holder for payment post
*
* Please note that some function names are partly in Dutch. Clieop03 is
* a Dutch banking standard and they have chosen to use Dutch line descriptions
*
* The Payment_Clieop_Transaction class is a data-holder for the main clieop class.
*
* @version $Revision$
* @access public
* @package Payment_Clieop
* @author Dave Mertens <dmertens@zyprexia.com>
*/
class Payment_Clieop_Transaction
{
    /**
    * @var string
    * @access private
    * @values 0000 (creditor) or 1002 (Debtor)
    */
    var $_TransactionType;

    /**
    * @var numeric string
    * @access private
    * @values CREDITOR or DEBTOR
    */
    var $_TransactionName;

    /**
    * @var integer
    * @access private
    */
    var $_Amount;

    /**
    * @var string
    * @access private
    */
    var $_AccountNumberSource;

    /**
    * @var string
    * @access private
    */
    var $_AccountNumberDest;

    /**
    * @var string
    * @access private
    */
    var $_InvoiceReference;

    /**
    * @var string
    * @access private
    */
    var $_Type;

    /**
    * @var string
    * @access private
    */
    var $_Name;

    /**
    * @var string
    * @access private
    */
    var $_City;

    /**
    * @var string
    * @access private
    */
    var $_Desciption;
    
    /**
    * Constructor for class
    * @param string transactionType        - constant CLIEOP_TRANSACTIE_INCASSO or CLIEOP_TRANSACTIE_BETALING
    * @return void
    * @access public
    */
    function __construct($transactionType)
    {
        $this->_Description = array();
        if ($transactionType == "00")
        {
            //creditor payment
            $this->_TransactionType = "0000";
            $this->_TransactionName = "CREDITOR";
        }
        else
        {
            //debtor payment
            $this->_TransactionType = "1002";
            $this->_TransactionName = "DEBTOR";
        }
    }
    
    /**
    * Fetch payment type
    * @return string
    * @access public
    */
    function getPaymentType()
    {
        return $this->_TransactionName;    //return type of class
    }
    
    /**
    * return transaction type
    * @return string
    * @access public
    */
    function getTransactionType()
    {
        return $this->_TransactionType;    //return special transaction type
    }

    /**
    * Property amount (in Eurocents)
    * @param integer Value    - Payment amount in euro cents (Rounded on 2 digits). Must be a positive number.
    * @return integer
    * @access public
    */
    function getAmount()
    {
        return $this->_Amount;
    }
    function setAmount($Value)
    {
        $this->_Amount = $Value;
    }
    
    /**
    * property AccountNumberSource
    * @param string Value    - Source bank account number (Max 10 tokens)
    * @return string
    * @access public
    */
    function getAccountNumberSource()
    {
        return $this->_AccountNumberSource;
    }
    function setAccountNumberSource($Value)
    {
        $this->_AccountNumberSource = $Value;
    }
    
    /**
    * property AccountNumberDest
    * @param string Value    - Destination bankaccount number
    * @return string
    * @access public
    */
    function getAccountNumberDest()
    {
        return $this->_AccountNumberDest;
    }
    function setAccountNumberDest($Value)
    {
        $this->_AccountNumberDest = $Value;
    }
    
    /**
    * property InvoiceReference 
    * @param string Value    - Invoice reference (Max 16 tokens)
    * @return string
    * @access public
    */
    function getInvoiceReference()
    {
        return $this->_InvoiceReference;
    }
    function setInvoiceReference($Value)
    {
        $this->_InvoiceReference = $Value;
    }
    
    /**
    * property Name
    * @param string Value    - Name of creditor or debtor
    * @return string
    * @access public
    */
    function getName()
    {
        return $this->_Name;
    }
    function setName($Value)
    {
        $this->_Name = $Value;
    }
    
    /**
    * property City
    * @param string Value    - City of creditor or debtor
    * @return string
    * @access public
    */
    
    function getCity()
    {
        return $this->_City;
    }
    function setCity($Value)
    {
        $this->_City = $Value;
    }
    
    /**
    * property Description
    * @param string Value    - Description for payment (Maximum 4 description lines)
    * @return array
    * @access public
    */
    function getDescription()
    {
        //return description array
        return $this->_Description;    
    }
    function setDescription($Value)
    {
        //only 4 descriptions are allowed for a payment post
        if (sizeof($this->_Description) < 5)
        {
            $this->_Description[] = $Value;
        }
    }
}

