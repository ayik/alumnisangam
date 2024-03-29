<?php


abstract class BaseAcademicPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'academic';

	
	const CLASS_DEFAULT = 'lib.model.Academic';

	
	const NUM_COLUMNS = 10;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'academic.ID';

	
	const USER_ID = 'academic.USER_ID';

	
	const DEGREE = 'academic.DEGREE';

	
	const DEGREEFLAG = 'academic.DEGREEFLAG';

	
	const YEAR = 'academic.YEAR';

	
	const YEARFLAG = 'academic.YEARFLAG';

	
	const DEPARTMENT = 'academic.DEPARTMENT';

	
	const DEPARTMENTFLAG = 'academic.DEPARTMENTFLAG';

	
	const INSTITUTE = 'academic.INSTITUTE';

	
	const INSTITUTEFLAG = 'academic.INSTITUTEFLAG';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'UserId', 'Degree', 'Degreeflag', 'Year', 'Yearflag', 'Department', 'Departmentflag', 'Institute', 'Instituteflag', ),
		BasePeer::TYPE_COLNAME => array (AcademicPeer::ID, AcademicPeer::USER_ID, AcademicPeer::DEGREE, AcademicPeer::DEGREEFLAG, AcademicPeer::YEAR, AcademicPeer::YEARFLAG, AcademicPeer::DEPARTMENT, AcademicPeer::DEPARTMENTFLAG, AcademicPeer::INSTITUTE, AcademicPeer::INSTITUTEFLAG, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'user_id', 'degree', 'degreeFlag', 'year', 'yearFlag', 'department', 'departmentFlag', 'institute', 'instituteFlag', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'UserId' => 1, 'Degree' => 2, 'Degreeflag' => 3, 'Year' => 4, 'Yearflag' => 5, 'Department' => 6, 'Departmentflag' => 7, 'Institute' => 8, 'Instituteflag' => 9, ),
		BasePeer::TYPE_COLNAME => array (AcademicPeer::ID => 0, AcademicPeer::USER_ID => 1, AcademicPeer::DEGREE => 2, AcademicPeer::DEGREEFLAG => 3, AcademicPeer::YEAR => 4, AcademicPeer::YEARFLAG => 5, AcademicPeer::DEPARTMENT => 6, AcademicPeer::DEPARTMENTFLAG => 7, AcademicPeer::INSTITUTE => 8, AcademicPeer::INSTITUTEFLAG => 9, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'user_id' => 1, 'degree' => 2, 'degreeFlag' => 3, 'year' => 4, 'yearFlag' => 5, 'department' => 6, 'departmentFlag' => 7, 'institute' => 8, 'instituteFlag' => 9, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/AcademicMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.AcademicMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = AcademicPeer::getTableMap();
			$columns = $map->getColumns();
			$nameMap = array();
			foreach ($columns as $column) {
				$nameMap[$column->getPhpName()] = $column->getColumnName();
			}
			self::$phpNameMap = $nameMap;
		}
		return self::$phpNameMap;
	}
	
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	
	public static function alias($alias, $column)
	{
		return str_replace(AcademicPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(AcademicPeer::ID);

		$criteria->addSelectColumn(AcademicPeer::USER_ID);

		$criteria->addSelectColumn(AcademicPeer::DEGREE);

		$criteria->addSelectColumn(AcademicPeer::DEGREEFLAG);

		$criteria->addSelectColumn(AcademicPeer::YEAR);

		$criteria->addSelectColumn(AcademicPeer::YEARFLAG);

		$criteria->addSelectColumn(AcademicPeer::DEPARTMENT);

		$criteria->addSelectColumn(AcademicPeer::DEPARTMENTFLAG);

		$criteria->addSelectColumn(AcademicPeer::INSTITUTE);

		$criteria->addSelectColumn(AcademicPeer::INSTITUTEFLAG);

	}

	const COUNT = 'COUNT(academic.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT academic.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AcademicPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AcademicPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = AcademicPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}
	
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = AcademicPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return AcademicPeer::populateObjects(AcademicPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			AcademicPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = AcademicPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinUser(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AcademicPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AcademicPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AcademicPeer::USER_ID, UserPeer::ID);

		$rs = AcademicPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinUser(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		AcademicPeer::addSelectColumns($c);
		$startcol = (AcademicPeer::NUM_COLUMNS - AcademicPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		UserPeer::addSelectColumns($c);

		$c->addJoin(AcademicPeer::USER_ID, UserPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AcademicPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = UserPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getUser(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addAcademic($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initAcademics();
				$obj2->addAcademic($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AcademicPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AcademicPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AcademicPeer::USER_ID, UserPeer::ID);

		$rs = AcademicPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAll(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		AcademicPeer::addSelectColumns($c);
		$startcol2 = (AcademicPeer::NUM_COLUMNS - AcademicPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		UserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + UserPeer::NUM_COLUMNS;

		$c->addJoin(AcademicPeer::USER_ID, UserPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = AcademicPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getUser(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addAcademic($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initAcademics();
				$obj2->addAcademic($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}

	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return AcademicPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(AcademicPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(AcademicPeer::ID);
			$selectCriteria->add(AcademicPeer::ID, $criteria->remove(AcademicPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; 		try {
									$con->begin();
			$affectedRows += BasePeer::doDeleteAll(AcademicPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	 public static function doDelete($values, $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(AcademicPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof Academic) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(AcademicPeer::ID, (array) $values, Criteria::IN);
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->begin();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public static function doValidate(Academic $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(AcademicPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(AcademicPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(AcademicPeer::DATABASE_NAME, AcademicPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = AcademicPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(AcademicPeer::DATABASE_NAME);

		$criteria->add(AcademicPeer::ID, $pk);


		$v = AcademicPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria();
			$criteria->add(AcademicPeer::ID, $pks, Criteria::IN);
			$objs = AcademicPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseAcademicPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/AcademicMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.AcademicMapBuilder');
}
