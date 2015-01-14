<?php

namespace PHPSemVerChecker\Operation;

use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ClassMethod;
use PHPSemVerChecker\SemanticVersioning\Level;

class ClassMethodAdded extends ClassMethodOperation {
	/**
	 * @var array
	 */
	protected $code = [
		'class' => ['V015', 'V016', 'V028'],
		'interface' => ['V034'],
		'trait' => ['V047', 'V048', 'V057'],
	];
	/**
	 * @var int
	 */
	protected $level = [
		'class' => [Level::MAJOR, Level::MAJOR, Level::PATCH],
		'interface' => [Level::MAJOR],
		'trait' => [Level::MAJOR, Level::MAJOR, Level::MAJOR],
	];
	/**
	 * @var string
	 */
	protected $reason = 'Method has been added.';
	/**
	 * @var string
	 */
	protected $fileAfter;
	/**
	 * @var \PhpParser\Node\Stmt
	 */
	protected $contextAfter;
	/**
	 * @var \PhpParser\Node\Stmt\ClassMethod
	 */
	protected $classMethodAfter;

	/**
	 * @param string                           $context
	 * @param string                           $fileAfter
	 * @param \PhpParser\Node\Stmt             $contextAfter
	 * @param \PhpParser\Node\Stmt\ClassMethod $classMethodAfter
	 */
	public function __construct($context, $fileAfter, Stmt $contextAfter, ClassMethod $classMethodAfter)
	{
		$this->context = $context;
		$this->visibility = $this->getVisibility($classMethodAfter);
		$this->fileAfter = $fileAfter;
		$this->contextAfter = $contextAfter;
		$this->classMethodAfter = $classMethodAfter;
	}

	/**
	 * @return string
	 */
	public function getLocation()
	{
		return $this->fileAfter;
	}

	/**
	 * @return int
	 */
	public function getLine()
	{
		return $this->classMethodAfter->getLine();
	}

	/**
	 * @return string
	 */
	public function getTarget()
	{
		$fqcn = $this->contextAfter->name;
		if ($this->contextAfter->namespacedName) {
			$fqcn = $this->contextAfter->namespacedName->toString();
		}
		return $fqcn . '::' . $this->classMethodAfter->name;
	}
}
