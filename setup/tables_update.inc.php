<?php
	/**************************************************************************\
	* eGroupWare - Webpage news admin                                          *
	* http://www.egroupware.org                                                *
	* --------------------------------------------                             *
	*  This program is free software; you can redistribute it and/or modify it *
	*  under the terms of the GNU General Public License as published by the   *
	*  Free Software Foundation; either version 2 of the License, or (at your  *
	*  option) any later version.                                              *
	* --------------------------------------------                             *
	* This program was sponsered by Golden Glair productions                   *
	* http://www.goldenglair.com                                               *
	\**************************************************************************/

	/* $Id$ */

	$test[] = '0.0.1';
	function news_admin_upgrade0_0_1()
	{
		return $setup_info['news_admin']['currentver'] = '0.8.1';
	}

	$test[] = '0.8.1';
	function news_admin_upgrade0_8_1()
	{
		$GLOBALS['egw_setup']->oProc->RenameTable('webpage_news','phpgw_news');

		return $setup_info['news_admin']['currentver'] = '0.8.1.001';
	}

	$test[] = '0.8.1.001';
	function news_admin_upgrade0_8_1_001()
	{
		$GLOBALS['egw_setup']->oProc->AddColumn('phpgw_news','news_cat',array('type' => 'int','precision' => 4,'nullable' => True));
		$GLOBALS['egw_setup']->oProc->query("update phpgw_news set news_cat='0'",__LINE__,__FILE__);

		return $setup_info['news_admin']['currentver'] = '0.8.1.002';
	}

	$test[] = '0.8.1.002';
	function news_admin_upgrade0_8_1_002()
	{
		$GLOBALS['egw_setup']->oProc->AddColumn('phpgw_news','news_teaser',array(
			'type' => 'varchar',
			'precision' => '255',
			'nullable' => True
		));

		return $GLOBALS['setup_info']['news_admin']['currentver'] = '0.9.14.500';
	}

	$test[] = '0.9.14.500';
	function news_admin_upgrade0_9_14_500()
	{
		$GLOBALS['egw_setup']->oProc->CreateTable('phpgw_news_export',array(
			'fd' => array(
				'cat_id' => array('type' => 'int','precision' => '4','nullable' => False),
				'export_type' => array('type' => 'int','precision' => '2','nullable' => True),
				'export_itemsyntax' => array('type' => 'int','precision' => '2','nullable' => True),
				'export_title' => array('type' => 'varchar','precision' => '255','nullable' => True),
				'export_link' => array('type' => 'varchar','precision' => '255','nullable' => True),
				'export_description' => array('type' => 'text', 'nullable' => True),
				'export_img_title' => array('type' => 'varchar','precision' => '255','nullable' => True),
				'export_img_url' => array('type' => 'varchar','precision' => '255','nullable' => True),
				'export_img_link' => array('type' => 'varchar','precision' => '255','nullable' => True),
			),
			'pk' => array('cat_id'),
			'fk' => array(),
			'ix' => array(),
			'uc' => array()
		));

		return $GLOBALS['setup_info']['news_admin']['currentver'] = '0.9.14.501';
	}

	$test[] = '0.9.14.501';
	function news_admin_upgrade0_9_14_501()
	{
		$GLOBALS['egw_setup']->oProc->AddColumn('phpgw_news','news_begin',array(
			'type' => 'int','precision' => '4','nullable' => True
		));
		$GLOBALS['egw_setup']->oProc->AddColumn('phpgw_news','news_end',array(
			'type' => 'int','precision' => '4','nullable' => True
		));
		$db2 = $GLOBALS['egw_setup']->db;
		$GLOBALS['egw_setup']->oProc->query('SELECT news_id,news_status FROM phpgw_news');
		while($GLOBALS['egw_setup']->oProc->next_record())
		{
			$unixtimestampmax = 2147483647;
			$db2->query('UPDATE phpgw_news SET news_begin=news_date,news_end=' . 
				(($GLOBALS['egw_setup']->oProc->f('news_status') == 'Active') ? $unixtimestampmax : 'news_date') .
				' WHERE news_id=' . $GLOBALS['egw_setup']->oProc->f('news_id'));
		}
		$newtbldef = array(
			'fd' => array(
				'news_id' => array('type' => 'auto','nullable' => False),
				'news_date' => array('type' => 'int','precision' => '4','nullable' => True),
				'news_subject' => array('type' => 'varchar','precision' => '255','nullable' => True),
				'news_submittedby' => array('type' => 'varchar','precision' => '255','nullable' => True),
				'news_content' => array('type' => 'blob','nullable' => True),
				'news_begin' => array('type' => 'int','precision' => '4','nullable' => True),
				'news_end' => array('type' => 'int','precision' => '4','nullable' => True),
				'news_cat' => array('type' => 'int','precision' => '4','nullable' => True),
				'news_teaser' => array('type' => 'varchar','precision' => '255','nullable' => True)
			),
			'pk' => array('news_id'),
			'fk' => array(),
			'ix' => array('news_date','news_subject'),
			'uc' => array()
		);
		$GLOBALS['egw_setup']->oProc->DropColumn('phpgw_news',$newtbldef,'news_status');

		return $GLOBALS['setup_info']['news_admin']['currentver'] = '0.9.14.502';
	}


	$test[] = '0.9.14.502';
	function news_admin_upgrade0_9_14_502()
	{
		$GLOBALS['egw_setup']->oProc->AddColumn('phpgw_news','is_html',array(
			'type' => 'int',
			'precision' => '2',
			'nullable' => False,
			'default' => '0'
		));

		return $GLOBALS['setup_info']['news_admin']['currentver'] = '0.9.14.503';
	}


	$test[] = '0.9.14.503';
	function news_admin_upgrade0_9_14_503()
	{
		return $GLOBALS['setup_info']['news_admin']['currentver'] = '1.0.0';
	}


	$test[] = '1.0.0';
	function news_admin_upgrade1_0_0()
	{
		$GLOBALS['egw_setup']->oProc->AlterColumn('phpgw_news','news_begin',array(
			'type' => 'int',
			'precision' => '4',
			'nullable' => False,
			'default' => '0',
		));

		return $GLOBALS['setup_info']['news_admin']['currentver'] = '1.0.0.001';
	}

	$test[] = '1.0.0.001';
	function news_admin_upgrade1_0_0_001()
	{
		$GLOBALS['egw_setup']->oProc->RenameTable('phpgw_news','egw_news');
		// timestamps have to be 64bit=8byte
		$GLOBALS['egw_setup']->oProc->AlterColumn('egw_news','news_date',array(
			'type' => 'int',
			'precision' => '8',
		));
		$GLOBALS['egw_setup']->oProc->AlterColumn('egw_news','news_begin',array(
			'type' => 'int',
			'precision' => '8',
			'nullable' => False,
			'default' => '0',
		));
		$GLOBALS['egw_setup']->oProc->AlterColumn('egw_news','news_end',array(
			'type' => 'int',
			'precision' => '8',
		));
		$GLOBALS['egw_setup']->oProc->RenameTable('phpgw_news_export','egw_news_export');

		return $GLOBALS['setup_info']['news_admin']['currentver'] = '1.2';
	}