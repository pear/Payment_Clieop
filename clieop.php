<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Dave Mertens <dmertens@zyprexia.com>                        |
// +----------------------------------------------------------------------+
//
// $Id$
/*
 Please note that public function names are partly in Dutch. This is because 
 also the clieop data strings has a dutch names. (batchvoorloopinfo, transactieinfo, etc).
 */

/**
* Main clieop class
*
* @version $Revision$
* @access public
* @author Dave Mertens <dmertens@zyprexia.com>
* @package Payment_Clieop
*/
class ClieopPayment extends clieop_baseobject
{
	/**
	* @var string
	* @access private
	*/
	var $_SenderIdent;

	/**
	* @var string
	* @access private
	*/
	var $_FileIdent;

	/**
	* @var string
	* @access private
	*/
	var $_TransactionType;

	/**
	* @var string
	* @access private
	*/
	var $_ClieopText;

	/**
	* @var string
	* @access private
	*/
	var $_PrincipalAccountNumber;

	/**
	* @var string
	* @access private
	*/
	var $_PrincipalName;

	/**
	* @var integer
	* @access private
	*/
	var $_BatchNumber;

	/**
	* @var integer
	* @access private
	*/
	var $_TransactionCount;

	/**
	* @var integer
	* @access private
	*/
	var $_TotalAmount;

	/**
	* @var string
	* @access private
	*/
	var $_AccountChecksum;

	/**
	* @var string
	* @access private
	*/
	var $_Description;

	/**
	* @var date (in DDMMYY format)
	* @access private
	*/
	var $_ProcessDate;

	/**
	* @var boolean
	* @access private
	*/
	var $_Test;

	/**
	* @var string
	* @access private
	*/
	var $_TransactionText;

	/**
	* Constructor for class
	* @return void
	* @access public
	*/
	function clieopPayment()
	{
		//init vars
		$this->_ProcessDate = "000000";	//process ASAP
		$this->_BatchNumber = 1;
		return 1;
	}
}


/**
*	master object for clieop objects
*
* @version $Revision$
* @access private
* @author Dave Mertens <dmertens@zyprexia.com>
* @package Payment_Clieop
*/
class clieop_baseobject
{

	/**
	* Alfa numeric filler
	* @param string text	- Text which needs to filled up
	* @param integer length	- The length of the required text
	* @return string
	* @access public
	*/
	function alfaFiller($text, $length)
	{
		//how many spaces do we need?
		$alfaLength = $length - strlen($text);
		
		//return string with spaces on right side
		return substr(str_repeat(" ", $alfaLength) . $text, $length);
	}
	
	/**
	* Numeric filler
	* @param string number	- number which needs to filled up (Will be converted to a string)
	* @param integer length	- The length of the required number
	* @return string
	* @access public
	*/
	function numFiller($number, $length)
	{
		//how many zeros do we need
		settype($number, "string");		//We need to be sure that number is a string. 001 will otherwise be parsed as 1
		$numberLength = $lentgh - strlen($number)
		
		//return original number woth zeros on the left
		return substr(str_repeat("0", $numberLength) . $number, $length);
	}
	
	/**
	* Numeric filler
	* @param integer length	- How many spaces do we need
	* @return string
	* @access public
	*/
	function Filler($Length)
	{
		return str_repeat(" ", $Length);
	}
}

?>